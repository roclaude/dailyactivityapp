<?php 
    require_once(dirname(__FILE__) . "/functions.php"); 

    if ( !$user->is_loggedin() ) {
        header('Location: index.php');
        exit();
    }

    $dashboard_user_id = false;
    if ( isset( $_GET[ "uid" ] ) && !empty( $_GET[ "uid" ] ) ) {
        $dashboard_user_id = $_GET[ "uid" ];
    } 

    $page_title = ( $dashboard_user_id ? "Dashboard" : "Team" ) . ( defined('SITE_NAME') ? ' | ' . SITE_NAME : null );
    $page       = $dashboard_user_id ? "dashboard" : "team";
?>

    <?php include_once( BASE_PATH . "/templates/header.php"); ?>

        <div class="container-fluid">
            <h1>Dashboard</h1>
            <div class="panel panel-default panel-user">

                <div class="panel-heading clearfix">
                    <div class="row">
                        <div class="col-sm-6 pull-left activities-box-title"><?= $dashboard_user_id ? $user->__get( "firstname" ) . "'s" : "Team" ?> Daily Activities</div>

                        <?php if ( $dashboard_user_id || ( !$dashboard_user_id && $user->__get( "account_type" ) == 1 ) ) : ?>
                            <div class="col-sm-6">
                                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#newDailyActivity">Add activity</button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade new-activity" id="newDailyActivity" tabindex="-1" role="dialog" aria-labelledby="newDailyActivity" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title pull-left" id="exampleModalLabel">Add activity</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="/" method="POST" id="add-activity-form">
                                    <div class="alert alert-danger" role="alert">
                                        Something went wrong!
                                    </div>
                                    <div class="alert alert-success" role="alert">
                                        Activity added successfully!
                                    </div>
                                    <div class="form-group">
                                        <label for="activityTitle">Activity Title</label>
                                        <input type="text" name="activity_title" id="activityTitle" class="form-control" placeholder="Title" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="activityTitle">Priority</label>
                                        <input type="number" name="activity_priority" id="activityPriority" min="1" max="5" class="form-control" placeholder="Priority" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="activityTitle">Tags</label>
                                        <input type="text" name="activity_tags" id="activityTags" class="form-control" placeholder="Tags" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="activityTitle">Due date</label>
                                        <input type="date" name="activity_due_date" id="activityDueDate" class="form-control" placeholder="Due date" required>
                                    </div>
                                    <?php if ( !$dashboard_user_id && $user->__get( "account_type" ) == 1 ) : ?>
                                        <?php $members = $database->get_all_members_wo_me( $user->__get( "id" ) ); ?>
                                        <div class="form-group">
                                            <label for="activityMember">Member</label>
                                            <select name="activity_member" class="form-control" id="activityMember">
                                                <option value="0">Select user</option>
                                                <?php 
                                                    foreach ( $members as $member ) {
                                                        echo "<option value=\"" . $member[ "id" ] . "\">" . $member[ "firstname" ] . " " . $member[ "lastname" ] . "</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ( $dashboard_user_id ) : ?>
                                        <input type="hidden" name="userid" id="userID" value="<?=$user->__get( "id" )?>" class="form-control">
                                    <?php endif; ?>
                                    <button type="submit" class="btn btn-primary">Add activity</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="table-activity-wrap">
                    <?php 
                        if ( $dashboard_user_id ) {
                            new ActivityTable( $database, $user->__get('id'), $user->__get('account_type'), $dashboard_user_id );
                        } else {
                            new ActivityTable( $database, $user->__get('id'), $user->__get('account_type') );
                        }
                    ?>
                </div>

            </div>
        </div>

    <?php include_once( BASE_PATH . "/templates/footer.php"); ?>

