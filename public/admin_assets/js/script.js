$( document ).ready(function() {
    $.validator.addMethod("noSpaces", function(value, element) {
        return value.indexOf(" ") != 0 && value != "";
    }, "No space allowed");

    $.validator.addMethod("specialChars", function(value, element) {
        var specialCharPattern = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
        return !specialCharPattern.test(value);
    }, "Special characters are not allowed.");
});

var displayedMessages = [];

function show_massage() {
    // setInterval(function(){
        $.ajax({
            url: site_url + 'admin/show_msg_noti/',
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(data) {
                var count = data.count;
                var message = data.message;
                $('#noti_number').html(count);

                var notificationList = document.getElementById("notification-list");

                if (Array.isArray(message)) {
                    var newMessages = message.filter(function(item) {
                        return !displayedMessages.includes(item.id);
                    });
                    newMessages.forEach(function(item) {
                        var notificationHTML = `
                          <li class="notification-message">
                              <a href="#" class="notification-link" data-id="${item.id}">
                                  <div class="media">
                                      <span class="avatar">
                                          <img alt="" src="#">
                                      </span>
                                      <div class="media-body">
                                          <p class="noti-details"><span class="noti-title">${item.message}</p>
                                          <p class="noti-time"><span class="notification-time">${item.created_at}</span></p>
                                      </div>
                                  </div>
                              </a>
                          </li>
                        `;
                        notificationList.innerHTML += notificationHTML;
                    
                        displayedMessages.push(item.id);
                    });
                }
            },
            error: function() {
                $('#result').html('An error occurred while fetching data.');
            }
        });
    // }, 1000);
}

// show_massage();

// $( document ).ready(function() {
    $(document).on("click", '.notification-link', function(event) {
        event.preventDefault();

        var notificationId = $(this).data("id");
        $.ajax({
            url: site_url + 'admin/notification_clicked/' + notificationId,
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                var message = data.message;                
                var notificationList = document.getElementById("notification-list");
                if (Array.isArray(message)) {
                    var newMessages = message.filter(function(item) {
                        return !displayedMessages.includes(item.id);
                    });
                    newMessages.forEach(function(item) {
                        var notificationHTML = `
                          <li class="notification-message">
                              <a href="#" class="notification-link" data-id="${item.id}">
                                  <div class="media">
                                      <span class="avatar">
                                          <img alt="" src="#">
                                      </span>
                                      <div class="media-body">
                                          <p class="noti-details"><span class="noti-title">${item.message}</p>
                                          <p class="noti-time"><span class="notification-time">${item.created_at}</span></p>
                                      </div>
                                  </div>
                              </a>
                          </li>
                        `;
                        notificationList.innerHTML += notificationHTML;
                        displayedMessages.push(item.id);
                    });
                }
            },
            error: function(response) {
                console.error(response);
                location.reload();
            }
        });
    });
// });

$(document).on("click", '#clear-noti', function(event) {
    event.preventDefault();
    var notificationId = $(this).data("id");
    $.ajax({
        url: site_url + 'admin/notification_clear/' + notificationId,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            console.log(response);
        },
        error: function(response) {
            // console.error(response);
            // location.reload();
        }
    });
});