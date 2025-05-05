<!DOCTYPE html>
<html lang="en">

<head>


    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>



    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    <title>
        DEV SQUAD
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <!-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- CSS Files -->
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.1/echo.iife.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">



    <script src="https://unpkg.com/imask"></script>
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css') }}?v=0.02" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/parsleyjs/src/parsley.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>



<body class="bg-gray-100">
    <div class="flex h-screen">
        @if (Auth::check())
            @include('layouts.sidebar')
        @endif
        <div class="flex-1 flex flex-col overflow-hidden" id = "app">
            @if (Auth::check())
                @include('layouts.header')
            @endif

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4">
                @yield('content')
            </main>
            @include('layouts.footer')
        </div>
    </div>


    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/parsleyjs/dist/parsley.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets/js/argon-dashboard.js') }}"></script>
    @stack('js')


    <script>
        $(document).ready(function() {

            @if (Auth::user())

                // Enable pusher logging - remove in production
                Pusher.logToConsole = true;

                var pusher = new Pusher('516f298ecbcf241b77a3', {
                    cluster: 'ap2',
                    encrypted: true,
                    authEndpoint: '/broadcasting/auth',
                    auth: {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }
                });

                var userId = {{ Auth::user()->id }};

                var channel = pusher.subscribe('private-notifications.' + userId);

                channel.bind('NewNotification', function(data) {
                    console.log('Received notification:', data.message);

                    // Create HTML for new notification
                    let newNotification = `
                        <div class="flex items-start space-x-3 notification-item new-notification" data-new="true">
                            <div class="flex-1">
                                <p class="m-1"><span class="font-bold text-gray-800">New Notification</span></p>
                                <p class="text-sm text-gray-500 m-1">${data.message}</p>
                                <p class="text-xs text-gray-400 m-1">Just now</p>
                            </div>
                        </div>
                        <div class="border-b m-0 border-gray-200"></div>
                    `;

                    // Prepend new notification
                    $('.notification-scroll').prepend(newNotification);

                    // Update badge count
                    let $count = $('#notificationCount');
                    let current = parseInt($count.text()) || 0;
                    $count.text(current + 1).removeClass('hidden').show();
                });
            @endif



            $("#logout-icon").click(function(e) {
                e.preventDefault(); // Prevent default action
                $("#logout-form").submit(); // Submit the logout form
            });

            // Toggle Sidebar on small screens
            $('#menu-toggle').click(function(event) {
                event.stopPropagation();
                $('#sidebar').toggleClass('-translate-x-full');
                $('#overlay').toggleClass('hidden'); // Show overlay when sidebar is open

                if ($(window).width() <= 768) {
                    if ($('#sidebar').hasClass('-translate-x-full')) {
                        $('#overlay').addClass('hidden'); // Hide overlay when sidebar is closed
                    } else {
                        $('#overlay').removeClass('hidden'); // Show overlay when sidebar is open
                    }
                }
            });

            // Close sidebar when clicking on overlay
            $('#overlay').click(function() {
                $('#sidebar').addClass('-translate-x-full');
                $('#overlay').addClass('hidden'); // Hide overlay
            });

            // Close sidebar when clicking outside of sidebar
            $(document).click(function(event) {
                if (!$(event.target).closest('#sidebar, #menu-toggle').length) {
                    if ($(window).width() <= 768 && !$('#sidebar').hasClass('-translate-x-full')) {
                        $('#sidebar').addClass('-translate-x-full');
                        $('#overlay').addClass('hidden'); // Hide overlay
                    }
                }
            });


            // prevent reloading mage on clicking upload file button
            $("#uploadBtn").click(function(event) {
                event.preventDefault(); // Prevent form submission
            });

            let filesArray = [];

            $('#uploadModal').on('show.bs.modal', function() {
                $("#uploaded-files").html("");
                $("#file-input").val("");
                $("#fileNameInput").val("");
                $("#file-name-error").addClass("hidden");
                filesArray = []; // 💥 This clears previous files
            });

            // Open file dialog when clicking on the upload box
            $("#upload-box").on("click", function() {
                $("#file-input").trigger("click");
            });

            // Handle file selection
            $("#file-input").on("change", function(e) {
                const newFiles = Array.from(e.target.files);
                filesArray.push(...newFiles); // Add selected files to the array
                updateFileDisplay();
                this.value = ""; // Reset the file input so the same file can be selected again if needed
            });

            // Function to update the displayed file names and input value
            function updateFileDisplay() {
                $("#uploaded-files").html(""); // Clear the visual list
                let fileNames = [];

                filesArray.forEach((file, index) => {
                    fileNames.push(file.name);

                    let fileHtml = `
            <div class="inline-flex text-sm items-center bg-gray-100 px-2 py-1 border rounded-md mr-2 mb-2 file-item" data-index="${index}">
                <span class="text-gray-800">${file.name}</span>
                <button type="button" class="ml-2 text-red-500 remove-file" data-index="${index}">&times;</button>
            </div>
        `;
                    $("#uploaded-files").append(fileHtml);
                });

                $("#fileNameInput").val(fileNames.join(", "));
            }


            // Remove file from the uploaded list (when clicking the "X" button)
            $(document).on("click", ".remove-row", function() {
                $(this).closest("tr").remove();

                // Re-index the SR numbers
                $("#file-table-body tr").each(function(index) {
                    $(this).find("td:first").text(index + 1); // Update SR number
                });
            });


            // Detect manual input change in filename field
            $("#fileNameInput").on("input", function() {
                let enteredNames = $(this).val().split(", ").filter(name => name.trim() !==
                    ""); // Get names entered by user

                // Filter filesArray to keep only those whose names are still in the input field
                filesArray = filesArray.filter(file => enteredNames.includes(file.name));

                updateFileDisplay(); // Refresh UI
            });

            // Handle form submission
            $("#submit-files").on("click", function() {
                let fileList = new DataTransfer();
                let fileName = $("#fileNameInput").val().trim();

                if (fileName === "") {
                    $("#file-name-error").removeClass("hidden");
                    return;
                }

                $("#file-name-error").addClass("hidden");

                // Append files to the table
                let tableBody = $("#file-table-body");
                let existingRowCount = tableBody.find("tr").length;

                filesArray.forEach((file, index) => {
                    // Append files to the DataTransfer object
                    fileList.items.add(file);

                    // Start numbering from existing rows
                    let srNo = existingRowCount + index + 1;

                    let rowHtml = `
        <tr class="border-b">
            <td class="p-2">${srNo}</td>
            <td class="p-2">${file.name}</td>
            <td class="p-2 text-right">
                <button class="bg-red-500 text-white px-4 py-1 text-xs rounded remove-row">&times;</button>
            </td>
        </tr>
    `;

                    tableBody.append(rowHtml);
                });

                // Append files to the DataTransfer object
                $("#file-input")[0].files = fileList.files;
                // Clear modal fields
                $("#uploaded-files").html("");
                // $("#file-input").val("");
                $("#fileNameInput").val("");
                // filesArray = [];

                // Close modal
                $("#uploadModal").modal("hide");
            });

            // Remove file from table
            $(document).on("click", ".remove-row", function() {
                $(this).closest("tr").remove();
            });




            function updateNotificationCount() {
                let unreadCount = $(".notification-item[data-new='true']").length;
                if (unreadCount > 0) {
                    $("#notificationCount").text(unreadCount).removeClass("hidden");
                } else {
                    $("#notificationCount").addClass("hidden");
                }
            }

            updateNotificationCount();

            $("#notificationBell").click(function(event) {
                event.stopPropagation();
                $("#notificationDropdown").toggle();
            });

            $(document).click(function(event) {
                if (!$(event.target).closest("#notificationDropdown, #notificationBell").length) {
                    $("#notificationDropdown").hide();
                }
            });

            // Mark individual notification
            $(".notification-item").click(function() {
                const item = $(this);
                const notificationId = item.data("id");

                $.ajax({
                    url: `/notifications/mark-read/${notificationId}`,
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            item.removeClass("new-notification").attr("data-new", "false");
                            updateNotificationCount();
                        }
                    }
                });
            });

            // Mark all as read
            $("#markAllRead").click(function() {
                $.ajax({
                    url: `/notifications/mark-all-read`,
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            $(".notification-item").removeClass("new-notification").attr(
                                "data-new", "false");
                            updateNotificationCount();
                        }
                    }
                });
            });


            // password toggle
            $(document).on("click", ".toggle-password", function() {
                let passwordField = $(this).siblings(".password-field");
                let icon = $(this).find("i");

                if (passwordField.attr("type") === "password") {
                    passwordField.attr("type", "text");
                    icon.removeClass("bi-eye-slash").addClass("bi-eye");
                } else {
                    passwordField.attr("type", "password");
                    icon.removeClass("bi-eye").addClass("bi-eye-slash");
                }
            });

            // Toggle Nested Table
            $(".accordion-toggle").on("click", function() {
                let target = $(this).data("target");
                $(target).toggleClass("hidden");

                // Rotate Icon
                $(this).find(".toggle-icon").toggleClass("rotate");
            });

            // 1. Load stored filters and apply them
            var storedFilters = JSON.parse(localStorage.getItem('selectedFilters')) || [];

            storedFilters.forEach(function(value) {
                $('.filter-checkbox[value="' + value + '"]').prop('checked', true);
            });

            generateAppliedFilters();

            // 2. Toggle filter dropdowns
            $('.filter-button').click(function(e) {
                e.stopPropagation();
                var $this = $(this);
                var options = $this.next('.filter-options');
                var icon = $this.find('i');

                var isVisible = options.is(':visible');

                $('.filter-options').slideUp();
                $('.filter-button i').removeClass('bi-caret-up-fill').addClass('bi-caret-down-fill');

                if (!isVisible) {
                    options.slideDown();
                    icon.removeClass('bi-caret-down-fill').addClass('bi-caret-up-fill');
                } else {
                    options.slideUp();
                    icon.removeClass('bi-caret-up-fill').addClass('bi-caret-down-fill');
                }
            });

            // 3. Close dropdown if clicked outside
            $(document).click(function() {
                $('.filter-options').slideUp();
                $('.filter-button i').removeClass('bi-caret-up-fill').addClass('bi-caret-down-fill');
            });

            // 4. Handle checkbox changes
            $('.filter-checkbox').change(function() {
                saveSelectedFilters();
                generateAppliedFilters();
            });

            // Save selected filters to localStorage
            function saveSelectedFilters() {
                var selected = [];
                $('.filter-checkbox:checked').each(function() {
                    selected.push($(this).val());
                });
                localStorage.setItem('selectedFilters', JSON.stringify(selected));
            }

            // Generate filter badges with close buttons
            function generateAppliedFilters() {
                var appliedFilters = $('#applied-filters');
                appliedFilters.html('');

                var selected = [];

                $('.filter-checkbox:checked').each(function() {
                    var label = $(this).closest('div').find('label').text().trim();
                    var value = $(this).val();

                    selected.push(value);

                    appliedFilters.append(`
            <span style="display:inline-flex;align-items:center;padding:2px 6px;border-radius:9999px;font-size:9px;background-color:#e5e7eb;color:#4b5563;margin-right:4px;margin-bottom:4px;">
                ${label}
                <button type="button" class="ml-1 text-gray-500 hover:text-red-500 remove-filter" data-value="${value}" style="margin-left:6px;font-size:12px;line-height:1;">&times;</button>
            </span>
        `);
                });

                localStorage.setItem('selectedFilters', JSON.stringify(selected));
            }

            // 5. Handle badge × removal
            $(document).on('click', '.remove-filter', function(e) {
                e.preventDefault();
                e.stopPropagation();

                var value = $(this).data('value');

                // Uncheck checkbox
                $('.filter-checkbox[value="' + value + '"]').prop('checked', false).trigger('change');

                // Remove from localStorage
                var currentFilters = JSON.parse(localStorage.getItem('selectedFilters')) || [];
                var updatedFilters = currentFilters.filter(f => f !== value);
                localStorage.setItem('selectedFilters', JSON.stringify(updatedFilters));

                // Remove the badge
                $(this).closest('span').remove();
            });

            $('#toggleFilters').click(function() {
                $('#filterSection').toggleClass('hidden');
                $(this).text(function(i, text) {
                    return text === "Filters" ? " Filters" : "Filters";
                });
            });
        });
    </script>
</body>

</html>
