<?php
// Define the Bengali months
$bengali_months = [
    "Boishakh", "Joishtho", "Asharh", "Srabon", "Bhadhon", "Ashwin", "Kartick", "Ogrohayon",
    "Poush", "Magh", "Falgun", "Chaitra"
];

// Define some key Bengali holidays
$holidays = [
    "Pohela Boishakh" => "2025-04-14",  // Example: Pohela Boishakh is April 14th, 2025
    "Durga Puja" => "2025-10-19",
    "Kali Puja" => "2025-11-14",
    "Diwali" => "2025-11-14"
];

// Function to get lunar phases (Purnima and Amavasya)
function get_moon_phases($year_start, $year_end) {
    // We'll use some pre-calculated moon phase data. 
    // In a real application, you could use an API or a library like ephem to calculate moon phases.
    $moon_phases = [
        "2025-04-29" => "Purnima (Full Moon)",
        "2025-05-14" => "Amavasya (New Moon)",
        "2025-06-29" => "Purnima (Full Moon)",
        "2025-07-14" => "Amavasya (New Moon)",
        // Add more moon phases here
    ];
    
    return $moon_phases;
}

// Function to generate the Bengali calendar for a given year
function generate_bengali_calendar($start_year, $end_year) {
    global $bengali_months, $holidays;

    // Get moon phases (Purnima and Amavasya) for the range of years
    $moon_phases = get_moon_phases($start_year, $end_year);

    $calendar_data = [];

    // Loop through each year
    for ($year = $start_year; $year <= $end_year; $year++) {
        $year_data = [];

        // Loop through each Bengali month
        for ($i = 0; $i < count($bengali_months); $i++) {
            $month_name = $bengali_months[$i];

            // For simplicity, assume the start date of each Bengali month is the same in each year
            $start_date = date('Y-m-d', strtotime("$year-04-14 +$i month"));
            $end_date = date('Y-m-d', strtotime("$start_date +1 month"));

            $month_data = [
                "start_date" => $start_date,
                "end_date" => $end_date,
                "holidays" => [],
                "moon_phases" => []
            ];

            // Check if any holidays fall in this month
            foreach ($holidays as $holiday => $date) {
                if ($date >= $start_date && $date <= $end_date) {
                    $month_data['holidays'][] = $holiday;
                }
            }

            // Check if any moon phases fall in this month
            foreach ($moon_phases as $moon_date => $moon_name) {
                if ($moon_date >= $start_date && $moon_date <= $end_date) {
                    $month_data['moon_phases'][] = "$moon_date: $moon_name";
                }
            }

            // Add the month data to the year data
            $year_data[$month_name] = $month_data;
        }

        // Add the year data to the calendar
        $calendar_data[$year] = $year_data;
    }

    return $calendar_data;
}

// Generate the Bengali calendar for the years 2025 and 2026
$calendar_data = generate_bengali_calendar(2025, 2026);

// Display the generated calendar
foreach ($calendar_data as $year => $year_data) {
    echo "<h2>Year $year:</h2>";
    foreach ($year_data as $month_name => $month_data) {
        echo "<h3>$month_name:</h3>";
        echo "Start Date: " . $month_data['start_date'] . "<br>";
        echo "End Date: " . $month_data['end_date'] . "<br>";
        if (!empty($month_data['holidays'])) {
            echo "Holidays: " . implode(", ", $month_data['holidays']) . "<br>";
        }
        if (!empty($month_data['moon_phases'])) {
            echo "Moon Phases: <br>";
            foreach ($month_data['moon_phases'] as $moon_phase) {
                echo $moon_phase . "<br>";
            }
        }
        echo "<br>";
    }
}
?>
