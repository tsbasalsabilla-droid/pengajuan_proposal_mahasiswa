<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?? 'App'; ?></title>

    <!-- CSS utama -->
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css'); ?>">
    
    <!-- CSS Sidebar -->
    <link rel="stylesheet" href="<?= base_url('assets/css/sidebar.css'); ?>">

    <!-- CSS tambahan (dinamis) -->
    <?php if (!empty($css)) : ?>
        <link rel="stylesheet" href="<?= base_url('assets/css/' . $css . '.css'); ?>">
    <?php endif; ?>

    <style>
        /* Paksa sidebar dan konten berdampingan */
        .d-flex { display: flex !important; }
        
        /* Ikon sidebar tetap kecil */
        .nav-icon svg, .nav-link svg, svg { 
            width: 18px !important; 
            height: 18px !important; 
        }
        
        /* Pastikan tidak ada margin body yang mengganggu */
        body { margin: 0; padding: 0; background-color: #f4f7fe; }

        /* Bootstrap utilities dasar */
        .flex-grow-1 {
            flex-grow: 1 !important;
        }

        .border-0 {
            border: 0 !important;
        }

        .shadow-sm {
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075) !important;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0,0,0,.125);
            border-radius: .25rem;
        }

        .font-weight-bold {
            font-weight: 700 !important;
        }

        .mb-1 {
            margin-bottom: .25rem !important;
        }

        .mb-4 {
            margin-bottom: 1.5rem !important;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .small {
            font-size: .875em;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            color: #212529;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: .25rem;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            text-decoration: none;
        }

        .btn-sm {
            padding: .25rem .5rem;
            font-size: .875rem;
            line-height: 1.5;
            border-radius: .2rem;
        }

        .btn-light {
            color: #212529;
            background-color: #f8f9fa;
            border-color: #f8f9fa;
        }

        .btn-light:hover {
            color: #212529;
            background-color: #e2e6ea;
            border-color: #dae0e5;
        }

        .px-3 {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }

        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }

        .table td, .table th {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table-borderless td, .table-borderless th {
            border: 0;
        }

        .mt-4 {
            margin-top: 1.5rem !important;
        }

        .p-3 {
            padding: 1rem !important;
        }

        .border-left {
            border-left: 1px solid #dee2e6 !important;
        }

        .border-primary {
            border-color: #007bff !important;
        }

        .text-dark {
            color: #212529 !important;
        }
    </style>
</head>
<body>