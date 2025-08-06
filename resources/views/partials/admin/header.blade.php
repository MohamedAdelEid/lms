<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) ? $title : 'Treasure Academy' }}</title>
    <!-- icon logo  -->
    <link rel="shortcut icon" type="image/png" href="/assets/images/logo/Treasure Academy logo dark-mode.png" sizes="32x32" />
    <!-- jquery cdn link "loading" -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- tailwind cdn link  -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- select cdn link  -->
    <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui-pro@5.0.0-rc.2/dist/css/coreui.min.css" rel="stylesheet"
        integrity="sha384-ry0/VADFZoMb+nqZUTCl4BKR2Tf8jjcAQf5gGULlcwkePPL1I8e20WTTUopDjrx6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- bootstrap link css  -->
    <link rel="stylesheet" href="/assets/css/styles.min.css" />
    <!-- admin link css  -->
    <link rel="stylesheet" href="/assets/css/admin.css">
    @livewireStyles
</head>
<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper bg-secondary-dark" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6"
        data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
