document.addEventListener("DOMContentLoaded", () => {
    const addFormModal = document.getElementById("addFormModal");
    const openModalBtn = document.getElementById("openModalBtn");
    const detailsModal = document.getElementById("detailsModal");

    openModalBtn.onclick = () => {
        addFormModal.classList.add("show");
    };

    window.onclick = (event) => {
        if (event.target === addFormModal) {
            addFormModal.classList.remove("show");
        } else if (event.target === detailsModal) {
            detailsModal.classList.remove("show");
        }
    };

    document.querySelectorAll('.tracking-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const trackingCode = this.dataset.code;

            fetch(`controllers/InfoController?code=${trackingCode}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('orderDetails').innerHTML = data.html;
                        document.getElementById('trackingCode').value = data.parcel.tracking_code;
                        document.getElementById('statusSelect').value = data.parcel.status;
                        detailsModal.classList.add("show");
                    }
                });
        });
    });
});