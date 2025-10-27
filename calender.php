
import tkinter as tk
from tkinter import ttk, messagebox
from PIL import ImageGrab
import serial
import datetime
import threading
import pandas as pd
import webbrowser
import time
import serial.tools.list_ports

class UARTInterface:
    def __init__(self, serial_port, baud_rate, log_file):
        self.serial_port = serial_port
        self.baud_rate = baud_rate
        self.log_file = log_file
        self.root = tk.Tk()
        self.root.title("UART Data Monitor")
        self.root.geometry("1400x600")  # Set the size of the window

        self.create_ui()
        
    def create_ui(self):
        style = ttk.Style()
        style.theme_use("clam")  # Change the theme to clam for better appearance
    
    # Set the style for Treeview
        style.configure("Treeview",
                        background="sky blue",
                        fieldbackground="sky blue",
                        foreground="black",
                        font=("Arial", 14, "bold"))

        style.map("Treeview",
                  background=[("selected", "blue")],
                  foreground=[("selected", "white")])
    
    # Set the style for Treeview headings
        style.configure("Treeview.Heading",
                        background="blue",
                        foreground="white",
                        font=("Arial", 24, "bold"),
                        anchor="center")  # Center align the heading text

        style.map("Treeview.Heading",
                  background=[("selected", "blue")],
                  foreground=[("selected", "white")])

        self.canvas = tk.Canvas(self.root, bg="sky blue", height=100)
        self.canvas.pack(fill=tk.X)
        
    # Add text "Intelligent 644 Nurse Call System" with blue background
        self.canvas.create_rectangle(0, 0, 1400, 100, fill="sky blue")
      #  logo_image = tk.PhotoImage(file="ns644\cropped.png")  # Replace "logo.png" with your image file path
      #  self.canvas.create_image(50, 50, anchor=tk.W, image=logo_image)

        # Add text "Intelligent 644 Nurse Call System"
      #  self.canvas.create_text(200, 50, anchor=tk.CENTER, text="Intelligent 644 Nurse Call System", font=("Arial", 34, "bold", "italic"), fill="white")
        self.canvas.create_text(600, 50, anchor=tk.CENTER, text="Intelligent 644 Nurse Call System", font=("Arial", 34, "bold", "italic"), fill="white")

    # Add current date and time beside the text
        self.current_datetime_label = self.canvas.create_text(1280, 50, anchor=tk.E, font=("Arial", 20), fill="white")
        self.update_datetime()  # Update datetime initially
        self.tree = ttk.Treeview(self.root)
   
        
        self.tree["columns"] = ("Date", "Bed", "Resetbed", "Status", "Call Time", "Call Reset Time", "Duration")
        self.tree.column("#0", width=0, stretch=tk.NO)
        self.tree.column("Date", anchor="center", width=150)
        self.tree.column("Bed", anchor="center", width=100)
        self.tree.column("Resetbed", anchor="center", width=150)
        self.tree.column("Status", anchor="center", width=100)
        self.tree.column("Call Time", anchor="center", width=300)
        self.tree.column("Call Reset Time", anchor="center", width=300)
        self.tree.column("Duration", anchor="center", width=150)
        self.tree.heading("#0", text="", anchor=tk.W)
        self.tree.heading("Date", text="Date", anchor="center")
        self.tree.heading("Bed", text="Bed", anchor="center")
        self.tree.heading("Resetbed", text="Resetbed", anchor="center")
        self.tree.heading("Status", text="Status", anchor="center")
        self.tree.heading("Call Time", text="Call Time", anchor="center")
        self.tree.heading("Call Reset Time", text="Call Reset Time", anchor="center")
        self.tree.heading("Duration", text="Duration", anchor="center")
        self.tree.pack(fill=tk.BOTH, expand=True)

        self.export_button = ttk.Button(self.root, text="Export to Excel", command=self.export_to_excel, style="Custom.TButton")
        self.export_button.pack(side=tk.LEFT, padx=450, pady=10)

        # Create a custom style for the button
        style.configure("Custom.TButton",
                        foreground="white",
                        background="green",
                        relief="raised",
                        font=("Arial", 12, "bold"))

        # Bind button press event to change button appearance
        self.export_button.bind("<ButtonPress-1>", self.button_pressed)
        self.export_button.bind("<ButtonRelease-1>", self.button_released)

        # Add button for serial port selection and baudrate setting
        self.serial_button = ttk.Button(self.root, text="Select Serial Port", command=self.select_serial_port, style="Custom.TButton")
        self.serial_button.pack(side=tk.LEFT, padx=2, pady=10)

    def button_pressed(self, event):
        self.export_button.configure(relief="sunken")

    def button_released(self, event):
        self.export_button.configure(relief="raised")

    def export_to_excel(self):
        data = []
        for child in self.tree.get_children():
            values = self.tree.item(child, 'values')
            data.append(values)

        df = pd.DataFrame(data, columns=["Date", "Bed", "Reset Bed No.", "Status", "Call Time", "Call Reset Time", "Duration"])
        excel_file = "uart_data.xlsx"
        df.to_excel(excel_file, index=False)
        print("Excel file exported successfully.")

        # Open the Excel file using the default application
        webbrowser.open(excel_file)

    def select_serial_port(self):
        # Get a list of available serial ports
        available_ports = serial.tools.list_ports.comports()
    
        # Create a dialog window to display available ports and select one
        port_dialog = tk.Toplevel(self.root)
        port_dialog.title("Select Serial Port")
        port_dialog.geometry("350x260")

        # Label to prompt the user to select a port
        prompt_label = tk.Label(port_dialog, text="")
        prompt_label.pack(pady=0)

        # Label to prompt the user to select a port
        prompt_label = tk.Label(port_dialog, text="Select Serial Port:")
        prompt_label.pack(pady=10)
    
        # Combobox to display available ports
        port_combobox = ttk.Combobox(port_dialog, values=[port.device for port in available_ports], state="readonly")
        port_combobox.pack(pady=10)
        port_combobox.current(0)  # Select the first port by default
    
        # Label to prompt the user to select baudrate
        baudrate_label = tk.Label(port_dialog, text="Select Baudrate:")
        baudrate_label.pack(pady=10)
    
        # Combobox to select baudrate
        baudrate_combobox = ttk.Combobox(port_dialog, values=["9600", "115200"], state="readonly")
        baudrate_combobox.pack(pady=10)
        baudrate_combobox.current(0)  # Select 9600 baudrate by default
    
        # Button to confirm port selection
        confirm_button = ttk.Button(port_dialog, text="Confirm", command=lambda: self.confirm_port_selection(port_combobox.get(), baudrate_combobox.get(), port_dialog))
        confirm_button.pack(pady=10)

    def confirm_port_selection(self, selected_port, selected_baudrate, port_dialog):
        # Update the selected serial port and baudrate
        self.serial_port = selected_port
        self.baud_rate = int(selected_baudrate)
    
        # Close the port selection dialog
        port_dialog.destroy()

        # Print the selected port and baudrate for verification
        print(f"Selected Serial Port: {self.serial_port}, Baudrate: {self.baud_rate}")

    def read_uart(self):
        try:
            with serial.Serial(self.serial_port, self.baud_rate, timeout=1) as ser:
                print(f"Listening on {self.serial_port} at {self.baud_rate} baud...")
                call_time = None
                current_date = None
                while True:
                    data = ser.readline().decode('utf-8').strip()
                    if data:
                        timestamp = datetime.datetime.now().strftime("%d-%m-%Y %H:%M:%S")
                        log_line = f"{timestamp}  {data}"
                        current_date, call_time = self.update_ui(log_line, call_time, current_date)
                        with open(self.log_file, 'a') as f:
                            f.write(log_line + '\n')
        except serial.SerialException as e:
            print(f"Error: {e}")



    def update_ui(self, log_line, call_time, current_date):
        parts = log_line.split(' ')
        if len(parts) >= 3:  # Ensure we have at least date and time
            date = parts[0]
            time_parts = parts[1].split(':')  # Split the time into hour, minute, second
            time = ':'.join(time_parts[:3])  # Join hour and minute and second back together
            data = ''.join(parts[2:])  # Join remaining parts as data

            try:
                data_value = int(data)
            
                if 0 < data_value < 65:
                    data_sum = data_value + 1028
                    if current_date is None:
                        current_date = date
                    if date != current_date:
                        current_date = date
                    call_time = time
                    self.tree.insert("", "end", values=(date if date == current_date else "", str(data_sum), "", "Normal", call_time, "", ""))
                    
                    # Create a thread to monitor and update the status after 1 minute
                    threading.Thread(target=self.update_status_after_delay, args=(call_time,)).start()
                elif data_value >= 65:
                    data_sum1 = data_value + 964
                    if date != current_date:
                        current_date = date
                    call_reset_time = time
                    duration = (datetime.datetime.strptime(call_reset_time, "%H:%M:%S") - datetime.datetime.strptime(call_time, "%H:%M:%S")).total_seconds()
                
                    # Check if reset bed data has been received within the last 3 minutes
                    if duration <= 60:
                        last_item = self.tree.get_children()[-1]
                        self.tree.set(last_item, "Resetbed", str(data_sum1))
                        self.tree.set(last_item, "Call Reset Time", call_reset_time)
                        self.tree.set(last_item, "Duration", duration)
                        self.tree.set(last_item, "Status", "Normal")
                    else:
                        # If reset bed data hasn't been received within 1 minute, set status to "Emergency"
                        last_item = self.tree.get_children()[-1]
                        self.tree.set(last_item, "Resetbed", str(data_sum1))
                        self.tree.set(last_item, "Call Reset Time", call_reset_time)
                        self.tree.set(last_item, "Duration", duration)
                        self.tree.set(last_item, "Status", "Emergency")
            except ValueError:
                print("Invalid data format:", data)
        return current_date, call_time

    def update_status_after_delay(self, call_time):
        # Sleep for 1 minute
        time.sleep(60)
        
        # Get the current item being inserted
        last_item = self.tree.get_children()[-1]
        
        # Get the current status
        current_status = self.tree.item(last_item, "values")[3]
        
        # If the status is still "Normal" after 1 minute, change it to "Emergency"
        if current_status == "Normal":
            self.tree.set(last_item, "Status", "Emergency")
    def update_datetime(self):
        # Update the current date and time continuously
        current_datetime = datetime.datetime.now().strftime("%d-%m-%Y   %H:%M:%S")
        self.canvas.itemconfig(self.current_datetime_label, text=current_datetime)
        self.root.after(1000, self.update_datetime)  # Update every 1000 milliseconds (1 second)



    def start(self):
        threading.Thread(target=self.read_uart, daemon=True).start()
        self.root.mainloop()

def main():
    serial_port = 'COM5'  # Change this to your USB/UART port
    baud_rate = 9600  # Match this with the baud rate configured in your PIC code
    log_file = "uart_data.txt"  # Path to the log file

    uart_interface = UARTInterface(serial_port, baud_rate, log_file)
    uart_interface.start()

if __name__ == "__main__":
    main()
