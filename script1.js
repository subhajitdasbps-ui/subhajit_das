let currentInput = "";
let currentOperation = "";
let result = 0;

function appendNumber(number) {
    currentInput += number;
    updateDisplay(currentInput);
}

function performOperation(operation) {
    if (currentInput !== "") {
        if (currentOperation !== "") {
            calculate();
        }
        currentOperation = operation;
        result = parseFloat(currentInput);
        currentInput = "";
    }
}

function calculate() {
    if (currentInput !== "") {
        switch (currentOperation) {
            case '+':
                result += parseFloat(currentInput);
                break;
            case '-':
                result -= parseFloat(currentInput);
                break;
            // Add more cases for other operations
        }
        currentInput = result.toString();
        currentOperation = "";
        updateDisplay(currentInput);
    }
}

function updateDisplay(value) {
    document.getElementById("display").textContent = value;
}




function performOperation(operation) {
    if (currentInput !== "") {
        if (operation === '%') {
            currentInput = (parseFloat(currentInput) / 100).toString();
            updateDisplay(currentInput);
            return;
        }

        if (currentOperation !== "") {
            calculate();
        }
        currentOperation = operation;
        result = parseFloat(currentInput);
        currentInput = "";
    }
}

function calculate() {
    if (currentInput !== "") {
        switch (currentOperation) {
            case '+':
                result += parseFloat(currentInput);
                break;
            case '-':
                result -= parseFloat(currentInput);
                break;
            case '*': // Multiplication
                result *= parseFloat(currentInput);
                break;
            case '/': // Division
                result /= parseFloat(currentInput);
                break;
            // Add more cases for other operations
        }
        currentInput = result.toString();
        currentOperation = "";
        updateDisplay(currentInput);
    }
}
function performScientificFunction(func) {
    if (currentInput !== "") {
        switch (func) {
            case 'sqrt':
                currentInput = Math.sqrt(parseFloat(currentInput)).toString();
                break;
            case 'sin':
                currentInput = Math.sin(parseFloat(currentInput)).toString();
                break;
			 case 'cos':
                currentInput = Math.cos(parseFloat(currentInput)).toString();
                break;
            case 'tan':
                currentInput = Math.tan(parseFloat(currentInput)).toString();
                break;
            // Add more cases for other scientific functions
        }
        updateDisplay(currentInput);
    }
}
function clearDisplay() {
    currentInput = "";
    updateDisplay(currentInput);
}
