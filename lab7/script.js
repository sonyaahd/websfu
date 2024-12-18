let currentInput = "0";
let currentOperator = null;
let firstOperand = null;
let resetInput = false;

function updateDisplay() {
    document.getElementById("calc-display").value = currentInput;
}

function appendNumber(number) {
    if (resetInput) {
        currentInput = number;
        resetInput = false;
    } else {
        currentInput = currentInput === "0" ? number : currentInput + number;
    }
    updateDisplay();
}

function appendDot() {
    if (!currentInput.includes(".")) {
        currentInput += ".";
        updateDisplay();
    }
}

function clearAll() {
    currentInput = "0";
    currentOperator = null;
    firstOperand = null;
    updateDisplay();
}

function clearEntry() {
    currentInput = "0";
    updateDisplay();
}

function backspace() {
    currentInput = currentInput.slice(0, -1) || "0";
    updateDisplay();
}

function setOperator(operator) {
    if (firstOperand === null) {
        firstOperand = parseFloat(currentInput);
    } else if (currentOperator) {
        calculate();
    }
    currentOperator = operator;
    resetInput = true;
}

function calculate() {
    if (currentOperator && firstOperand !== null) {
        const secondOperand = parseFloat(currentInput);
        switch (currentOperator) {
            case "+":
                currentInput = (firstOperand + secondOperand).toString();
                break;
            case "-":
                currentInput = (firstOperand - secondOperand).toString();
                break;
            case "*":
                currentInput = (firstOperand * secondOperand).toString();
                break;
            case "/":
                currentInput = secondOperand !== 0 ? (firstOperand / secondOperand).toString() : "Error";
                break;
        }
        currentOperator = null;
        firstOperand = null;
        updateDisplay();
    }
}

function toggleSign() {
    currentInput = (parseFloat(currentInput) * -1).toString();
    updateDisplay();
}

function calculatePercent() {
    currentInput = (parseFloat(currentInput) / 100).toString();
    updateDisplay();
}

function calculateReciprocal() {
    currentInput = parseFloat(currentInput) !== 0 ? (1 / parseFloat(currentInput)).toString() : "Error";
    updateDisplay();
}

function calculateSqrt() {
    currentInput = parseFloat(currentInput) >= 0 ? Math.sqrt(parseFloat(currentInput)).toString() : "Error";
    updateDisplay();
}
