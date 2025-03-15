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
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css') }}?v=0.05" rel="stylesheet" />
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

            // file uploading

            let filesArray = [];

            // Open file dialog when clicking on the upload box
            $("#upload-box").on("click", function() {
                $("#file-input").trigger("click");
            });

            // Handle file selection
            $("#file-input").on("change", function(event) {
                let files = event.target.files;

                for (let i = 0; i < files.length; i++) {
                    let file = files[i];

                    if (file) {
                        filesArray.push(file);

                        let fileHtml = `
                <div class="inline-flex text-sm items-center bg-gray-100 px-2 py-1 border rounded-md mr-2 mb-2">
                    <span class="text-gray-800">${file.name}</span>
                    <button type="button" class="ml-2 text-red-500 remove-file" data-index="${filesArray.length - 1}">&times;</button>
                </div>
            `;

                        $("#uploaded-files").append(fileHtml);
                    }
                }
            });


            // Remove file from the uploaded list
            $(document).on("click", ".remove-file", function() {
                let index = $(this).data("index");
                filesArray.splice(index, 1);
                $(this).parent().remove();
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


        });
    </script>
</body>

</html>
