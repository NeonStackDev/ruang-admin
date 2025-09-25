(function ($) {
    console.log(123);

    const $bell = $("#notifyDropdown");
    const $parent = $bell.closest(".nav-item");
    const $dropdownMenu = $parent.find(".notify");
    const $notifyCount = $("#notifyCount");
    // Toggle dropdown on click
    $bell.on("click", function (e) {
        console.log(123);

        e.stopPropagation(); // stop bubbling so doc click won't close immediately
        $parent.toggleClass("show");
    });

    // Close dropdown on outside click
    $(document).on("click", function (e) {
        if (!$parent.is(e.target) && $parent.has(e.target).length === 0) {
            $parent.removeClass("show");
        }
    });

    // Handle clicking a notification to mark as read
    $(document).on("click", ".notify-item", function (e) {
        e.preventDefault();
        const notificationId = $(this).data("id");
        console.log(notificationId);
        
        // Mark as read via AJAX
        $.ajax({
            url: "/api/service/getNotify",
            method: "POST",
            data: { id: notificationId },
            success: function () {
                // Remove clicked notification from list
                $(this).remove();
                // Update badge count
                const currentCount = parseInt($notifyCount.text(), 10);
                $notifyCount.text(Math.max(currentCount - 1, 0));
            }.bind(this)
        });
    });
    function loadNotifications() {
        $.ajax({
            url: "/api/service/getNotify", // your server endpoint
            method: "GET",
            dataType: "json",
            beforeSend: function () {

            },
            success: function (data) {
                if (data.length === 0) {
                    $dropdownMenu.html("<div style='padding:10px;'>No notifications</div>");
                } else {
                    let html = "";
                    data.forEach(function (notify) {
                        html += `<a href="${notify.url}" class="notify-item" data-id="${notify.id}">🔔 ${notify.text}</a>`;
                    });
                    $dropdownMenu.html(html);
                    $notifyCount.text(data.length);
                }

            },
            error: function () {

            }
        });
    }

    // Initial load
    loadNotifications();

    // Auto-refresh every 10 seconds (10000 ms)
    setInterval(loadNotifications, 1000);

})(jQuery);
