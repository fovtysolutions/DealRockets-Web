// parser.js

function parseJson(data) {
    try {
        // Clean up the string by removing unwanted characters
        // Remove the triple backticks and newlines
        data = data.replace(/^```json\s*\n/, '').replace(/\n```$/, '').replace(/\n/g, '').trim();

        // Parse the cleaned JSON data
        let parsedData = JSON.parse(data);

        // Optionally, process the data
        // For example, return the parsed data as a stringified JSON object
        return JSON.stringify(parsedData);
    } catch (error) {
        // Return error message if JSON is invalid
        return JSON.stringify({ error: "Invalid JSON" });
    }
}

// Get input data from command-line arguments
const inputData = process.argv[2];  // Get the input data passed as argument

// Call the parseJson function and output the result
console.log(parseJson(inputData));
