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
    jQuery('.'+clase).each(function() {
        $(this).datepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            defaultDate: today,
            startDate: minDate,
            endDate: maxDate,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true
        });
    });
}

function dateOnChange(clase="campo-fecha") {
    $('.'+clase).on('change', function () {
        // id del input: por ejemplo "published_from" o "published_to"
        const fieldId = this.id;
        const value = this.value;

        // Asegúrate que el input existe y tiene wire:model
        const el = document.getElementById(fieldId);
        if (!el) {
            console.warn('Input para Livewire no encontrado con id:', fieldId);
            return;
        }

        // Actualiza el valor del input y dispara evento 'input' (bubbles) para Livewire
        el.value = value;
        el.dispatchEvent(new Event('input', { bubbles: true }));
    });
}
