var currentURL = window.location.href;
var index = currentURL.lastIndexOf('v3/');
var newURL = currentURL.substring(0, index + 3);

var baseURL = window.location.href;
var splitURL = baseURL.split('/'); 
const uri = splitURL.slice(0, 6).join('/'); 
const BASE_URL = splitURL.slice(0,4).join('/');
  // Toast function
  function showToast(message, bgClass) {
    const toastContainerHtml = `
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="liveToast" class="toast bg-success" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body text-white">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    `;

    const toastContainer = document.createRange().createContextualFragment(toastContainerHtml);    
    document.body.appendChild(toastContainer);    
    const toastLiveExample = document.getElementById('liveToast');

    const toastBody = toastLiveExample.querySelector('.toast-body');
    toastBody.textContent = message;
    toastLiveExample.classList.remove('bg-primary', 'bg-danger', 'bg-success');
    toastLiveExample.classList.add(bgClass);

    // Tampilkan toast
    const toast = new bootstrap.Toast(toastLiveExample);
    toast.show();


    // client
    function clientToast(message, type) {
        var toastContainer = $('#toastContainer');
    
        var toastClass = 'bg-info'; // default
        if (type === 'success') {
            toastClass = 'bg-success';
        } else if (type === 'error') {
            toastClass = 'bg-danger';
        }
    
        var toastHtml = `
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
                <div class="toast-header ${toastClass} text-white">
                    <strong class="mr-auto">Notification</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">${message}</div>
            </div>
        `;
    
        toastContainer.append(toastHtml);
    
        var toastElList = [].slice.call(toastContainer.children('.toast'));
        var toast = new bootstrap.Toast(toastElList[toastElList.length - 1], {
            autohide: true
        });
        toast.show();
    }
    
}