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

function setGetParameter(paramName, paramValue)
{
    var url = window.location.href;

    if (url.indexOf(paramName + "=") >= 0) {
        var prefix = url.substring(0, url.indexOf(paramName));
        var suffix = url.substring(url.indexOf(paramName));
        suffix = suffix.substring(suffix.indexOf("=") + 1);
        suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
        url = prefix + paramName + "=" + paramValue + suffix;
    }
    else {
        url += (url.indexOf("?") < 0) ? "?" : "&";
        url += paramName + "=" + paramValue;
    }
    history.replaceState(null, null, url);
}

function getParameterByName(name)
{
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(window.location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

document.addEventListener('DOMContentLoaded', () => {
    const csrf_token = $("input[name='_token']").val();
    var lang = $("html").attr('lang');
    var rtl = (lang  == 'ar');

    // Disable Current element after click
    $(document).on('click','.disable_after_click',function(event) {
        setTimeout( () => $(this).attr('disabled','disabled') ,1);
    });

    $('button[type="submit"]').on('click', function() {
        setTimeout(() => $('button[type="submit"]').prop('disabled', true) , 1);
    });

    var deleteModalEl = document.getElementById('confirmDeleteModal');
    if(deleteModalEl !== null) {
        deleteModalEl.addEventListener('shown.bs.modal', function (event) {
            let action = event.relatedTarget.dataset.action;
            document.getElementById('confirmDeleteForm').setAttribute('action',action);
        });

        deleteModalEl.addEventListener('hidden.bs.modal', function (event) {
            document.getElementById('confirmDeleteForm').setAttribute('action','#');
        });
    }
});