function trackParcel() {
    const trackingCode = document.getElementById('trackingCode').value;
    if (trackingCode) {
        updateURL(trackingCode);
        fetchTrackingInfo(trackingCode);
    }
}

function fetchTrackingInfo(trackingCode) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'controllers/TrackController?code=' + trackingCode, true);
    xhr.onload = function() {
        if (this.status == 200) {
            document.getElementById('trackingResult').style.display = 'block';
            document.getElementById('trackingResult').innerHTML = this.responseText;
            saveTrackingCode(trackingCode);
        }
    }
    xhr.send();
}

function saveTrackingCode(code) {
    let trackingCodes = JSON.parse(localStorage.getItem('tracking_codes')) || [];
    if (!trackingCodes.includes(code)) {
        trackingCodes.push(code);
        if (trackingCodes.length > 5) {
            trackingCodes.shift(); // Keep only the latest 5 tracking codes
        }
        localStorage.setItem('tracking_codes', JSON.stringify(trackingCodes));
        updateTrackingHistory();
    }
}

function updateTrackingHistory() {
    let trackingCodes = JSON.parse(localStorage.getItem('tracking_codes')) || [];
    const trackingHistoryList = document.getElementById('trackingHistoryList');
    trackingHistoryList.innerHTML = '';
    
    if (trackingCodes.length === 0) {
        let listItem = document.createElement('p');
        listItem.textContent = 'No tracking history yet';
        trackingHistoryList.appendChild(listItem);
    } else {
        trackingCodes.slice().reverse().forEach(code => { // Reverse the order for display
            let listItem = document.createElement('li');
            let link = document.createElement('a');
            link.href = "javascript:void(0);";
            link.onclick = () => fillInputAndFetchInfo(code);
            link.textContent = code;
            listItem.appendChild(link);
            trackingHistoryList.appendChild(listItem);
        });
    }
}

function fillInputAndFetchInfo(code) {
    document.getElementById('trackingCode').value = code;
    updateURL(code);
    fetchTrackingInfo(code);
    closeModal();
}

function updateURL(code) {
    const newURL = window.location.origin + window.location.pathname + '?tracking=' + code;
    history.pushState({ path: newURL }, '', newURL);
}

var modal = document.getElementById("trackingHistoryModal");
var btn = document.getElementById("trackingHistoryBtn");

btn.onclick = function() {
    modal.classList.add("show");
    updateTrackingHistory();
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.classList.remove("show");
    }
}

function closeModal() {
    modal.classList.remove("show");
}

document.getElementById('clearHistoryBtn').addEventListener('click', function() {
    localStorage.removeItem('tracking_codes');
    document.getElementById('trackingHistoryList').innerHTML = '';
    closeModal();
});

document.addEventListener('DOMContentLoaded', updateTrackingHistory);

document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const trackingCode = urlParams.get('tracking');
    if (trackingCode) {
        document.getElementById('trackingCode').value = trackingCode;
        fetchTrackingInfo(trackingCode);
    }
});

document.getElementById('trackingCode').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        trackParcel();
    }
});
