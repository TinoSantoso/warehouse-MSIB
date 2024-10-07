<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse MSIB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        @media (max-width: 768px) {
            .navbar-nav {
                flex-direction: column;
            }
            .navbar-collapse {
                justify-content: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Warehouse MSIB</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <form class="d-flex flex-fill my-2 my-lg-0 me-2" role="search">
                        <input class="form-control me-2 w-75" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-secondary w-25" type="submit">Search</button>
                    </form>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../public/index.php">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Menu
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../views/categories.php">Category</a></li>
                                <li><a class="dropdown-item" href="../views/products.php">Product</a></li>
                                <li><a class="dropdown-item" href="../views/warehouses.php">Warehouse</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

        </nav>
    </div>
    
    <?php
    // Determine the current page based on the URL path
    $currentRoute = basename($_SERVER['REQUEST_URI']); // Get the current route (e.g., index.php, categories.php)
    $pageTitle = 'Homepage'; // Default title
    $param_id = $_GET['edit'];
        
    // Update the title based on the route
    switch ($currentRoute) {
        case 'categories.php':
        case 'categories.php?edit='.$param_id:
            $pageTitle = 'Categories';
            break;
        case 'products.php':
        case 'products.php?edit='.$param_id:
            $pageTitle = 'Products';
            break;
        case 'warehouses.php':
        case 'warehouses.php?edit='.$param_id:
            $pageTitle = 'Warehouses';
            break;
        case 'index.php':
        default:
            $pageTitle = 'Homepage';
            break;
    }
    ?>
    <section class="bg-secondary text-light py-3">
        <div class="container-fluid position-relative p-0">
            <div class="container">
                <h2><?= $pageTitle; ?></h2> <!-- Dynamic h2 text -->
            </div>
        </div>
    </section>