function initDatePicker(selector)
{
    flatpickr(selector, {
        minDate: "today",
        dateFormat: flatpickrFormat,
    });
}

function flashMessage(content, state = 'success')
{
    content.icon = 'fa-solid fa-bell';
    
    $.notify(content,{
        template: '<div data-notify="container" class="col-xs-11 col-sm-4 alert alert-{0}" role="alert"><button type="button" aria-hidden="true" class="btn-close" data-notify="dismiss"></button><span data-notify="icon"></span> <span data-notify="title">{1}</span> <span data-notify="message">{2}</span><div class="progress" data-notify="progressbar"><div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div></div><a href="{3}" target="{4}" data-notify="url"></a></div>',
        type: state,
        placement: {
            from: "top",
            align: "center"
        },
        delay: 5000,
    });
}


function attachEventToClass(selector,handler,event = 'click')
{
    document.querySelectorAll(selector).forEach(item => {
        item.addEventListener(event, handler);
    });
}

function openModal(selector)
{
    let target = document.getElementById(selector);
    let targetModal = bootstrap.Modal.getInstance(target);
    if(targetModal == null) {
        targetModal = new bootstrap.Modal(target)
    }
    setTimeout( () => targetModal.show(), 500);
}

function closeModal(selector)
{
    let curModal = bootstrap.Modal.getInstance(document.getElementById(selector));
    if(curModal != null) {
        curModal.hide();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const csrf_token = $("input[name='_token']").val();
    const lang = $("html").attr('lang');
    const rtl = (lang  == 'ar');

    setTimeout( () => {
        $('.select-picker').select2({
            width: '100%'
        });
    },2000);

    // Show Password Functionality
    togglePasswordField = function(event) {
        let parentElement = event.target.closest(".password-with-toggler");

        let passwordElem = parentElement.querySelector('.password');
        let type = passwordElem.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordElem.setAttribute('type', type);
        this.classList.toggle('icon-eye-slash');
    };
    attachEventToClass('.toggle-password',togglePasswordField);

    // Disable Current element after click
    $(document).on('click','.disable_after_click',function(event) {
        setTimeout( () => $(this).attr('disabled','disabled') ,1);
    });

    var deleteModal = document.getElementById('confirmDeleteModal')
    if(deleteModal != null) {
        deleteModal.addEventListener('shown.bs.modal', function (event) {
            let action = event.relatedTarget.dataset.action;
            document.getElementById('common-delete-form').action = action;
        });        
    }
});