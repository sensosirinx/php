(() => {
  'use strict'
  const forms = document.querySelectorAll('.needs-validation')
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }
      form.classList.add('was-validated')
    }, false)
  })
})()

$('.selectpicker').selectpicker();
$('input[name="delivery_type"]').change(function (data) {
  let deliveryType = parseInt(data.currentTarget.value)
  if (deliveryType === 2) {
    $('#form').attr('action', '/delivery_slow')
  } else {
    $('#form').attr('action', '/delivery_fast')
  }
})

