<?php
require_once '../../controllers/productController.php';
require_once '../../controllers/usersController.php';
require_once '../../controllers/ordersController.php';



?>



<?php include_once '../header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="d-flex flex-column p-3">
                <h4 class="text-center">Listify Admin</h4>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" onclick="loadContent('./dashboardSummary.php')"><svg width="25px"
                                height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M21.4498 10.275L11.9998 3.1875L2.5498 10.275L2.9998 11.625H3.7498V20.25H20.2498V11.625H20.9998L21.4498 10.275ZM5.2498 18.75V10.125L11.9998 5.0625L18.7498 10.125V18.75H14.9999V14.3333L14.2499 13.5833H9.74988L8.99988 14.3333V18.75H5.2498ZM10.4999 18.75H13.4999V15.0833H10.4999V18.75Z"
                                        fill="#ffffff"></path>
                                </g>
                            </svg> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="loadContent('./inventoryAdminDashboard.php')"><svg width="25px"
                                height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M6.29977 5H21L19 12H7.37671M20 16H8L6 3H3M9 20C9 20.5523 8.55228 21 8 21C7.44772 21 7 20.5523 7 20C7 19.4477 7.44772 19 8 19C8.55228 19 9 19.4477 9 20ZM20 20C20 20.5523 19.5523 21 19 21C18.4477 21 18 20.5523 18 20C18 19.4477 18.4477 19 19 19C19.5523 19 20 19.4477 20 20Z"
                                        stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </g>
                            </svg> Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="loadContent('./ordersAdminDashboard.php')"><svg fill="#ffffff"
                                height="25px" width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512.001 512.001"
                                xml:space="preserve" stroke="#ffffff">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g>
                                        <g>
                                            <path
                                                d="M463.996,126.864L340.192,3.061C338.232,1.101,335.574,0,332.803,0H95.726C67.725,0,44.944,22.782,44.944,50.784v410.434 c0,28.001,22.781,50.783,50.783,50.783h320.547c28.001,0,50.783-22.781,50.783-50.783V134.253 C467.056,131.482,465.955,128.824,463.996,126.864z M343.254,35.678h0.001l88.126,88.126h-58.242 c-7.984,0-15.49-3.109-21.134-8.753c-5.643-5.643-8.752-13.148-8.751-21.131V35.678z M446.159,461.217 c-0.001,16.479-13.407,29.885-29.885,29.885H95.726c-16.479,0-29.885-13.406-29.885-29.885V50.784 c0.001-16.479,13.407-29.886,29.885-29.886h226.631v73.021c-0.002,13.565,5.28,26.318,14.872,35.909 c9.591,9.592,22.345,14.874,35.911,14.874h73.019V461.217z">
                                            </path>
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path
                                                d="M376.882,209.049H135.119c-5.771,0-10.449,4.678-10.449,10.449V361.94c0,5.771,4.678,10.449,10.449,10.449h241.763 c5.771,0,10.449-4.678,10.449-10.449V219.498C387.331,213.728,382.652,209.049,376.882,209.049z M245.551,351.492h-99.984V324.92 h0.001h99.983V351.492z M245.551,304.022h-99.984v-26.606h0.001h99.983V304.022z M245.551,256.518h-99.984v-26.572h99.984V256.518 z M366.433,351.492h-99.984V324.92h99.984V351.492z M366.433,304.022h-99.984v-26.606h99.984V304.022z M366.433,256.518h-99.984 v-26.572h99.984V256.518z">
                                            </path>
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path
                                                d="M139.796,392.86h-4.678c-5.771,0-10.449,4.678-10.449,10.449c0,5.771,4.678,10.449,10.449,10.449h4.678 c5.771,0,10.449-4.678,10.449-10.449C150.245,397.539,145.567,392.86,139.796,392.86z">
                                            </path>
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path
                                                d="M275.091,392.86H173.599c-5.771,0-10.449,4.678-10.449,10.449c0,5.771,4.678,10.449,10.449,10.449h101.492 c5.771,0,10.449-4.678,10.449-10.449C285.54,397.539,280.862,392.86,275.091,392.86z">
                                            </path>
                                        </g>
                                    </g>
                                </g>
                            </svg> Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="loadContent('./userAdminDashboard.php')"><svg width="25px"
                                height="25px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <title>users</title>
                                    <desc>Created with sketchtool.</desc>
                                    <g id="web-app" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g id="users" fill="#ffffff">
                                            <path
                                                d="M8,13 C6.34314575,13 5,11.6568542 5,10 C5,8.34314575 6.34314575,7 8,7 C9.65685425,7 11,8.34314575 11,10 C11,11.6568542 9.65685425,13 8,13 Z M16,13 C14.3431458,13 13,11.6568542 13,10 C13,8.34314575 14.3431458,7 16,7 C17.6568542,7 19,8.34314575 19,10 C19,11.6568542 17.6568542,13 16,13 Z M8,15 C10.3893851,15 12.5341111,16.0475098 14,17.7083512 C14,18.1839232 14,18.6144728 14,19 L2,19 C2,18.6144728 2,18.1839232 2,17.7083512 C3.46588891,16.0475098 5.61061495,15 8,15 Z M16,19 L16,16.9519717 L15.4994784,16.3848843 C15.1151403,15.949432 14.6965808,15.550843 14.2491048,15.1921858 C14.8126186,15.0663701 15.3985585,15 16,15 C18.3893851,15 20.5341111,16.0475098 22,17.7083512 L22,19 L16,19 Z"
                                                id="Shape"> </path>
                                        </g>
                                    </g>
                                </g>
                            </svg> Customers</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="../logout.php"><svg width="25px" height="25px"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M15 16.5V19C15 20.1046 14.1046 21 13 21H6C4.89543 21 4 20.1046 4 19V5C4 3.89543 4.89543 3 6 3H13C14.1046 3 15 3.89543 15 5V8.0625M11 12H21M21 12L18.5 9.5M21 12L18.5 14.5"
                                        stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </g>
                            </svg> Sign out</a></li>
                </ul>

            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-10 main-content">
            <div id="content-area">
                <h3>Welcome to E-Shop Admin</h3>
                <p>Select a page from the sidebar to load content.</p>
            </div>
        </main>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js for Sales Chart -->

<script>

    function loadContent(page) {
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
            document.getElementById("content-area").innerHTML = this.responseText;
        };
        xhttp.open("GET", page, true);
        xhttp.send();
    }
</script>