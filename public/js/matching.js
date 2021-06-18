// Minimal configuration
const matchesId = "matches";
const totalId = "total";
const errorsId = "errors";

// Attributes
const email_key = "email";
const percent_key = "percent";
const average_key = "average";
const data_key = "data";
const attributes_key = "attributes";
const meta_key = "meta";
const errors_key = "errors";
const message_key = "message";

// Elements
let matchesElement = document.getElementById(matchesId);
let totalElement = document.getElementById(totalId);

let errorsElement = document.getElementById(errorsId);
errorsElement.hidden = true;

// Functionality
function match() {
    let fd = new FormData();
    let files = $('#file')[0].files;

    // Check file selected or not
    if(files.length > 0 ) {
        fd.append('file', files[0]);

        $.ajax({
            url: '/match',
            type: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {
                if(response != 0) {
                    response = JSON.parse(response);
                    displayMatchings(response)
                } else {
                    alert('file not uploaded');
                }
            },
            error: function (e) {
                if (!e.responseText)
                    return;

                let err = JSON.parse(e.responseText);
                if (err[errors_key]) {
                    displayErrorMessage(err);
                }
            }
        });
    } else {
        alert("Please select a file.");
    }
}

function resetContent() {
    matchesElement.innerHTML = "";
    totalElement.innerHTML = "";

    // Error element
    errorsElement.innerHTML = "";
    errorsElement.hidden = true;
}

function displayMatchings(response) {
    resetContent();
    prepareSeparateMatching(response);
    prepareAverageScore(response);
}

function prepareSeparateMatching(response) {
    let data = response[data_key];
    matchesElement.appendChild(prepareTableHeader());
    matchesElement.appendChild(prepareTableBody(data));
}

function prepareTableBody(data) {
    let tb = document.createElement("tbody");
    for (let i = 0; i < data.length; i++)
        tb.appendChild(prepareMatchRow(data[i]));

    return tb;
}

function prepareTableHeader() {
    // Parent
    let head = document.createElement("thead");

    let divEl = document.createElement("tr");

    // Email
    let divEmail = document.createElement("th");
    divEmail.innerText = email_key;
    divEl.appendChild(divEmail);

    // Percent
    let divPercent = document.createElement("th");
    divPercent.innerText = percent_key + "%";
    divEl.appendChild(divPercent);

    head.appendChild(divEl);

    return head;
}

function prepareMatchRow(array) {
    let attributes = array[attributes_key];

    // Parent
    let divEl = document.createElement("tr");

    // Email
    let divEmail = document.createElement("td");
    divEmail.innerText = attributes[email_key];
    divEl.appendChild(divEmail);

    // Percent
    let divPercent = document.createElement("td");
    divPercent.innerText = attributes[percent_key];
    divEl.appendChild(divPercent);

    return divEl;
}

function prepareAverageScore(response) {
    totalElement.innerText = response[meta_key][average_key] + "%";
}

// Errors
function displayErrorMessage(err) {
    resetContent();
    errorsElement.innerText = err[errors_key][message_key];
    errorsElement.hidden = false;
}