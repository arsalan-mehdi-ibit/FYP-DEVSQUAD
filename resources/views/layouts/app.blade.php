<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css') }}?v=0.07" rel="stylesheet" />
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
            $("#logout-icon").click(function(e) {
                e.preventDefault(); // Prevent default action
                $("#logout-form").submit(); // Submit the logout form
            });



            // function adjustHeader() {
            //     if ($(window).width() > 768) {
            //         // Ensure header starts after sidebar on large screens
            //         $('#main-header').css('margin-left', '18rem');
            //     } else {
            //         $('#main-header').css('margin-left', '0'); // Reset for small screens
            //     }
            // }

            // adjustHeader(); // Initial setup

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

            // $(window).resize(function() {
            //     adjustHeader();
            // });
            // Dropdown functionality
            $("#dropdownButton").on("click", function(event) {
                $("#dropdownMenu").toggleClass("hidden");
                event.stopPropagation();
            });

            $(".dropdown-item").on("click", function() {
                let selectedValue = $(this).text();
                $("#selectedOption").text(selectedValue);
                $("#dropdownMenu").addClass("hidden");
            });

            $(document).on("click", function(event) {
                if (!$(event.target).closest("#dropdownButton, #dropdownMenu").length) {
                    $("#dropdownMenu").addClass("hidden");
                }
            });

            //accordian icon change
            $('.accordion-button').click(function() {
                let icon = $(this).find('i');

                setTimeout(() => {
                    if ($(this).hasClass('collapsed')) {
                        icon.removeClass('bi-chevron-down').addClass('bi-chevron-right');
                    } else {
                        icon.removeClass('bi-chevron-right').addClass('bi-chevron-down');
                    }
                }, 100);
            });
            // prevent reloading mage on clicking upload file button
            $("#uploadBtn").click(function(event) {
                event.preventDefault(); // Prevent form submission
            });

            let filesArray = [];

            // Open file dialog when clicking on the upload box
            $("#upload-box").on("click", function() {
                $("#file-input").trigger("click");
            });

            // Handle file selection
            $("#file-input").on("change", function(event) {
                let files = Array.from(event.target.files);

                if (files.length > 0) {
                    filesArray = [...filesArray, ...files]; // Append new files to the array
                    updateFileDisplay();
                }
            });

            // Function to update the displayed file names and input value
            function updateFileDisplay() {
                $("#uploaded-files").html(""); // Clear the file list display
                let fileNames = [];

                filesArray.forEach((file, index) => {
                    fileNames.push(file.name); // Store file names for input field

                    let fileHtml = `
            <div class="inline-flex text-sm items-center bg-gray-100 px-2 py-1 border rounded-md mr-2 mb-2 file-item" data-index="${index}">
                <span class="text-gray-800">${file.name}</span>
                <button type="button" class="ml-2 text-red-500 remove-file" data-index="${index}">&times;</button>
            </div>
        `;
                    $("#uploaded-files").append(fileHtml);
                });

                $("#fileNameInput").val(fileNames.join(", ")); // Update input field with file names
            }

            // Remove file from the uploaded list (when clicking the "X" button)
            $(document).on("click", ".remove-file", function() {
                let index = $(this).data("index");

                filesArray.splice(index, 1); // Remove file from array
                updateFileDisplay(); // Refresh display after removing
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
                let fileName = $("#fileNameInput").val().trim();

                if (fileName === "") {
                    $("#file-name-error").removeClass("hidden");
                    return;
                }

                $("#file-name-error").addClass("hidden");

                // Append files to the table
                let tableBody = $("#file-table-body");
                filesArray.forEach((file, index) => {
                    let rowHtml = `
            <tr class="border-b">
                <td class="p-2">${index + 1}</td>
                <td class="p-2">${file.name}</td>
                <td class="p-2 text-right">
                    <button class="bg-red-500 text-white px-4 py-1 text-xs rounded remove-row">&times;</button>
                </td>
            </tr>
        `;

                    tableBody.append(rowHtml);
                });

                // Clear modal fields
                $("#uploaded-files").html("");
                $("#file-input").val("");
                $("#fileNameInput").val("");
                filesArray = [];

                // Close modal
                $("#uploadModal").modal("hide");
            });

            // Remove file from table
            $(document).on("click", ".remove-row", function() {
                $(this).closest("tr").remove();
            });


            // add contractor details dynamically
            $("#addContractorBtn").click(function() {
                let rowCount = $("#contractor-table-body tr").length + 1;

                let newRow = `
            <tr class="border-b">
                <td class="p-2 text-left">${rowCount}</td>
                <td class="p-2">
                    <select class="w-56 px-2 py-1 border rounded-md bg-gray-100">
                        <option>Select Contractor</option>
                        <option>Amery Craft</option>
                        <option>Brenda Marshall</option>
                    </select>
                </td>
                <td class="p-2 flex">
                    <select class="bg-gray-300 text-sm px-2 py-1 border border-gray-400 rounded-l-md">
                        <option>USD</option>
                        <option>CAD</option>
                    </select>
                    <input type="text" class="w-40 px-2 py-1 text-sm border rounded-r-md bg-gray-100" placeholder="Contractor Rate">
                </td>
                <td class="p-2 text-right">
                    <button class="removeRow text-md bg-red-500 text-white px-3 py-0 rounded">X</button>
                </td>
            </tr>`;

                $("#contractor-table-body").append(newRow);
            });

            $(document).on("click", ".removeRow", function() {
                $(this).closest("tr").remove();
            });

            // add button only appear when accordian is open
            $("#collapseTwo").on('show.bs.collapse', function() {
                $("#addContractorBtn").removeClass("hidden");
            }).on('hide.bs.collapse', function() {
                $("#addContractorBtn").addClass("hidden");
            });

            // notification dropdown
            function updateNotificationCount() {
                let unreadCount = $(".notification-item[data-new='true']").length;
                if (unreadCount > 0) {
                    $("#notificationCount").text(unreadCount).removeClass("hidden");
                } else {
                    $("#notificationCount").addClass("hidden");
                }
            }

            // Update count on page load
            updateNotificationCount();

            // Toggle dropdown on bell click
            $("#notificationBell").click(function(event) {
                event.stopPropagation();
                $("#notificationDropdown").toggle();
            });

            // Hide dropdown when clicking outside
            $(document).click(function(event) {
                if (!$(event.target).closest("#notificationDropdown, #notificationBell").length) {
                    $("#notificationDropdown").hide();
                }
            });

            // Mark notifications as read when clicked
            $(".notification-item").click(function() {
                $(this).removeClass("new-notification").attr("data-new", "false");
                updateNotificationCount();
            });

            $("#markAllRead").click(function() {
                $(".notification-item").removeClass("new-notification").attr("data-new", "false");
                updateNotificationCount();
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

            // Add Task
            $(document).on("click", ".add-task", function() {
                let taskBody = $(this).closest(".p-3").find(".task-body");
                let nextSr = taskBody.find("tr").length + 1;

                let newRow = `
            <tr>
                <td>${nextSr}</td>
                <td><input type="text" class="form-control p-1 task-title" placeholder="Title"></td>
                <td><input type="text" class="form-control p-1 task-desc" placeholder="Task description"></td>
                <td><input type="number" class="form-control p-1 task-hours" placeholder="Hours"></td>
                <td class="text-center">
                    <button class="save-task bg-blue-900 text-white px-3 py-1 rounded-full">Save</button>
                     <button class="edit-task hidden px-2 py-1 rounded-lg bg-yellow-100 hover:bg-orange-200 transition-all text-xs">
                    <span class="bi bi-pencil text-black"></span> </button>
                    <button class="remove-task px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs">
                                    <span class="bi bi-trash text-red-500"></span>
                                </button>

                   
                </td>
            </tr>
        `;

                taskBody.append(newRow);
            });

            // Save Task
            $(document).on("click", ".save-task", function() {
                let row = $(this).closest("tr");
                let title = row.find(".task-title").val();
                let desc = row.find(".task-desc").val();
                let hours = row.find(".task-hours").val();

                row.html(`
            <td>${row.index() + 1}</td>
            <td>${title}</td>
            <td>${desc}</td>
            <td>${hours}</td>
            <td class="text-center">
                <button class="edit-task px-2 py-1 rounded-lg bg-yellow-100 hover:bg-orange-200 transition-all text-xs">
                    <span class="bi bi-pencil text-black"></span> </button>
                <button class="remove-task px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs ">
                                    <span class="bi bi-trash text-red-500"></span>
                                </button>
            </td>
        `);
            });

            // Edit Task
            $(document).on("click", ".edit-task", function() {
                let row = $(this).closest("tr");
                let title = row.find("td:nth-child(2)").text();
                let desc = row.find("td:nth-child(3)").text();
                let hours = row.find("td:nth-child(4)").text();

                row.html(`
            <td>${row.index() + 1}</td>
            <td><input type="text" class="form-control p-1 task-title" value="${title}"></td>
            <td><input type="text" class="form-control p-1 task-desc" value="${desc}"></td>
            <td><input type="number" class="form-control p-1 task-hours" value="${hours}"></td>
            <td class="text-center">
                <button class="save-task bg-blue-900 text-white px-3 py-1 rounded-full">Save</button>
                <button class="remove-task px-2 py-1 rounded-lg bg-red-100 hover:bg-red-200 transition-all text-xs ">
                                    <span class="bi bi-trash text-red-500"></span>
                                </button>
            </td>
        `);
            });
            // remove
            $(document).on("click", ".remove-task", function() {
                let row = $(this).closest("tr");
                let taskBody = row.closest(".task-body");

                row.remove();

                // Recalculate SR numbers
                taskBody.find("tr").each(function(index) {
                    $(this).find("td:first").text(index + 1);
                });

            });
        });
    </script>
</body>

</html>
