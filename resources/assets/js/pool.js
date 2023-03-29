import Echo from "laravel-echo";

window.Pusher = require('pusher-js');
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: "e10514f9da8f4760f300",
    cluster: 'ap1',
    // encrypted: false,
    // forceTLS: false
});
