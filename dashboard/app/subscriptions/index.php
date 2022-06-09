<?php
include '../../../includes/connection.php';
include '../../../includes/misc/autoload.phtml';
include '../../../includes/dashboard/autoload.phtml';
dashboard\primary\head();
?>
<!-- ============================================================== -->

<div class="container-fluid" id="content" style="display:none;">

    <!-- ============================================================== -->

    <!-- Start Page Content -->

    <!-- ============================================================== -->

    <!-- File export -->

    <div class="row">

        <div class="col-12">

            <?php dashboard\primary\heador(); ?>

            <?php if ($_SESSION['timeleft']) { ?>

                <div class="alert alert-warning alert-rounded">Your account subscription expires, in less than a month, check account details for exact date.</div>

            <?php
            } ?>

            <button data-toggle="modal" type="button" data-target="#create-subscription" class="dt-button buttons-print btn btn-primary mr-1"><i class="fas fa-plus-circle fa-sm text-white-50"></i> Create Subscription</button>

            <br>

            <br>

            <div class="alert alert-info alert-rounded">Please watch tutorial video if confused <a href="https://youtube.com/watch?v=1lHjDeB3dA0" target="tutorial">https://youtube.com/watch?v=1lHjDeB3dA0</a> You may also join Discord and ask for help!

            </div>

            <div id="create-subscription" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <div class="modal-header d-flex align-items-center">

                            <h4 class="modal-title">Add Subscription</h4>

                            <button type="button" class="close ml-auto" data-dismiss="modal" aria-hidden="true">x</button>

                        </div>

                        <div class="modal-body">

                            <form method="post">

                                <div class="form-group">

                                    <label for="recipient-name" class="control-label">Subscription Name:</label>

                                    <input type="text" class="form-control" name="subname" placeholder="Anything you want" required>

                                </div>

                                <div class="form-group">

                                    <label for="recipient-name" class="control-label">Subscription Level: <i class="fas fa-question-circle fa-lg text-white-50" data-toggle="tooltip" data-placement="top" title="When the keys you create are redeemed, KeyAuth will assign the subscriptions with the same level as the key to the user being created. So basically, you can have several user ranks aka subscriptions."></i></label>

                                    <input type="text" class="form-control" placeholder="License Key Level" name="level" required>

                                </div>

                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>

                            <button class="btn btn-danger waves-effect waves-light" name="addsub">Add</button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>



            <div id="rename-app" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <div class="modal-header d-flex align-items-center">

                            <h4 class="modal-title">Rename Application</h4>

                            <button type="button" class="close ml-auto" data-dismiss="modal" aria-hidden="true">×</button>

                        </div>

                        <div class="modal-body">

                            <form method="post">

                                <div class="form-group">

                                    <label for="recipient-name" class="control-label">Name:</label>

                                    <input type="text" class="form-control" name="name" placeholder="New Application Name">

                                </div>

                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>

                            <button class="btn btn-danger waves-effect waves-light" name="renameapp">Add</button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>





            <script type="text/javascript">
                var myLink = document.getElementById('mylink');



                myLink.onclick = function() {





                    $(document).ready(function() {

                        $("#content").fadeOut(100);

                        $("#changeapp").fadeIn(1900);

                    });



                }
            </script>

            <div class="card">

                <div class="card-body">

                    <div class="table-responsive">

                        <table id="file_export" class="table table-striped table-bordered display">

                            <thead>

                                <tr>

                                    <th>Subscription Name</th>

                                    <th>License Level</th>

                                    <th>Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php
                                if ($_SESSION['app']) {
                                    ($result = mysqli_query($link, "SELECT * FROM `subscriptions` WHERE `app` = '" . $_SESSION['app'] . "'")) or die(mysqli_error($link));
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_array($result)) {
                                            echo "<tr>";
                                            echo "  <td>" . $row["name"] . "</td>";
                                            echo "  <td>" . $row["level"] . "</td>";
                                            // echo "  <td>". $row["status"]. "</td>";
                                            echo '<td><button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                                Manage

                                            </button>

                                            <div class="dropdown-menu"><form method="post">

                                                <button class="dropdown-item" name="deletesub" value="' . $row['name'] . '">Delete</button>

												<button class="dropdown-item" name="editsub" value="' . $row['name'] . '">Edit</button></div></td></tr></form>';
                                        }
                                    }
                                }
                                ?>

                            </tbody>

                            <tfoot>

                                <tr>

                                    <th>Subscription Name</th>

                                    <th>License Level</th>

                                    <th>Action</th>

                                </tr>

                            </tfoot>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Show / hide columns dynamically -->



    <!-- Column rendering -->



    <!-- Row grouping -->



    <!-- Multiple table control element -->



    <!-- DOM / jQuery events -->



    <!-- Complex headers with column visibility -->



    <!-- language file -->



    <!-- Setting defaults -->



    <!-- Footer callback -->



    <?php
    if (isset($_POST['addsub'])) {
        $resp = misc\sub\add($_POST['subname'], $_POST['level']);
        switch ($resp) {
            case 'failure':
                dashboard\primary\error("Failed to create subscription!");
                break;
            case 'success':
                dashboard\primary\success("Successfully created subscription!");
                break;
            default:
                dashboard\primary\error("Unhandled Error! Contact us if you need help");
                break;
        }
    }

    if (isset($_POST['deletesub'])) {
        $resp = misc\sub\deleteSingular($_POST['deletesub']);
        switch ($resp) {
            case 'failure':
                dashboard\primary\error("Failed to delete subscription!");
                break;
            case 'success':
                dashboard\primary\success("Successfully deleted subscription!");
                break;
            default:
                dashboard\primary\error("Unhandled Error! Contact us if you need help");
                break;
        }
    }
    if (isset($_POST['editsub'])) {
        $subscription = misc\etc\sanitize($_POST['editsub']);
        $result = mysqli_query($link, "SELECT * FROM `subscriptions` WHERE `name` = '$subscription' AND `app` = '" . $_SESSION['app'] . "'");
        if (mysqli_num_rows($result) == 0) {
            mysqli_close($link);
            dashboard\primary\error("Subscription not Found!");
            echo "<meta http-equiv='Refresh' Content='2'>";
            return;
        }
        $row = mysqli_fetch_array($result);
        $level = $row["level"];
        echo '<div id="edit-webhook" class="modal show" role="dialog" aria-labelledby="myModalLabel" style="display: block;" aria-modal="true">

                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <div class="modal-header d-flex align-items-center">

												<h4 class="modal-title">Edit Subscription</h4>

                                                <button type="button" onClick="window.location.href=window.location.href" class="close ml-auto" data-dismiss="modal" aria-hidden="true">x</button>

                                            </div>

                                            <div class="modal-body">

                                                <form method="post"> 

                                                    <div class="form-group">

                                                        <label for="recipient-name" class="control-label">Subscription Level:</label>

                                                        <input type="text" class="form-control" name="level" value="' . $level . '" required>

														<input type="hidden" name="subscription" value="' . $subscription . '">

                                                    </div>

                                            </div>

                                            <div class="modal-footer">

                                                <button type="button" onClick="window.location.href=window.location.href" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>

                                                <button class="btn btn-danger waves-effect waves-light" name="savesub">Save</button>

												</form>

                                            </div>

                                        </div>

                                    </div>

									</div>';
    }
    if (isset($_POST['savesub'])) {
        $subscription = misc\etc\sanitize($_POST['subscription']);
        $level = misc\etc\sanitize($_POST['level']);
        mysqli_query($link, "UPDATE `subscriptions` SET `level` = '$level' WHERE `name` = '$subscription' AND `app` = '" . $_SESSION['app'] . "'");
        dashboard\primary\success("Successfully Updated Settings!");
        echo "<meta http-equiv='Refresh' Content='2'>";
    }
    ?>



    <!-- ============================================================== -->

    <!-- End PAge Content -->

    <!-- ============================================================== -->

    <!-- ============================================================== -->

    <!-- Right sidebar -->

    <!-- ============================================================== -->

    <!-- .right-sidebar -->

    <!-- ============================================================== -->

    <!-- End Right sidebar -->

    <!-- ============================================================== -->

</div>

<!-- ============================================================== -->

<!-- End Container fluid  -->

<!-- ============================================================== -->

<!-- ============================================================== -->

<!-- footer -->

<!-- ============================================================== -->

<footer class="footer text-center">

    Copyright &copy; 2020-<script>
        document.write(new Date().getFullYear())
    </script> KeyAuth

</footer>

<!-- ============================================================== -->

<!-- End footer -->

<!-- ============================================================== -->

</div>

<!-- ============================================================== -->

<!-- End Page wrapper  -->

<!-- ============================================================== -->

</div>

<!-- ============================================================== -->

<!-- End Wrapper -->

<!-- ============================================================== -->

<!-- ============================================================== -->





<!-- ============================================================== -->

<!-- All Jquery -->

<!-- ============================================================== -->



<!-- Bootstrap tether Core JavaScript -->

<script src="https://cdn.keyauth.uk/dashboard/assets/libs/popper-js/dist/umd/popper.min.js"></script>

<script src="https://cdn.keyauth.uk/dashboard/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- apps -->

<script src="https://cdn.keyauth.uk/dashboard/dist/js/app.min.js"></script>

<script src="https://cdn.keyauth.uk/dashboard/dist/js/app.init.dark.js"></script>

<script src="https://cdn.keyauth.uk/dashboard/dist/js/app-style-switcher.js"></script>

<!-- slimscrollbar scrollbar JavaScript -->

<script src="https://cdn.keyauth.uk/dashboard/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>

<script src="https://cdn.keyauth.uk/dashboard/assets/extra-libs/sparkline/sparkline.js"></script>

<!--Wave Effects -->

<script src="https://cdn.keyauth.uk/dashboard/dist/js/waves.js"></script>

<!--Menu sidebar -->

<script src="https://cdn.keyauth.uk/dashboard/dist/js/sidebarmenu.js"></script>

<!--Custom JavaScript -->

<script src="https://cdn.keyauth.uk/dashboard/dist/js/feather.min.js"></script>

<script src="https://cdn.keyauth.uk/dashboard/dist/js/custom.min.js"></script>

<!--This page JavaScript -->

<!--chartis chart-->

<script src="https://cdn.keyauth.uk/dashboard/assets/libs/chartist/dist/chartist.min.js"></script>

<script src="https://cdn.keyauth.uk/dashboard/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>

<!--c3 charts -->

<script src="https://cdn.keyauth.uk/dashboard/assets/extra-libs/c3/d3.min.js"></script>

<script src="https://cdn.keyauth.uk/dashboard/assets/extra-libs/c3/c3.min.js"></script>

<!--chartjs -->

<script src="https://cdn.keyauth.uk/dashboard/assets/libs/chart-js/dist/chart.min.js"></script>

<script src="https://cdn.keyauth.uk/dashboard/dist/js/pages/dashboards/dashboard1.js"></script>

<script src="https://cdn.keyauth.uk/dashboard/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>

<!-- start - This is for export functionality only -->

<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>


<script src="https://cdn.keyauth.uk/dashboard/dist/js/pages/datatable/datatable-advanced.init.js"></script>

</body>

</html>