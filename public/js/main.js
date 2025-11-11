function imagePreview() {
    document.getElementById('image').addEventListener('change', (e) => {
        const file = e.target.files[0];
        const preview = document.getElementById('preview');
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (ev) => {
            preview.src = ev.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    });
}

function initializeDatePicker(minDate = new Date(), maxDate = new Date(), clase="campo-fecha") {
    let today = new Date();
    jQuery('.'+clase).datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
        defaultDate: today,
        startDate: minDate,
        endDate: maxDate,
        minDate: minDate,
        maxDate: maxDate,
        todayHighlight: true
    });
}
