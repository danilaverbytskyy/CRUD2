<?php $this->layout('layout') ?>

<div class="container">
    <div class="row">
        <a href="/logout">Log out</a>
        <div class="col-md-12">
            <h1>All Tasks</h1>
            <a href="/addTask" class="btn btn-success">Add Task</a>
            <?php if(isset($_SESSION['message'])): ?>
                <?php echo '<br>' . $_SESSION['message'] ?>
            <?php endif;?>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (isset($tasks)): ?>
                    <?php $taskCounter = 0; ?>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td><?= ++$taskCounter; ?></td>
                            <td><?= $task['title']; ?></td>
                            <td>
                                <a href="/show/<?= $task['task_id']; ?>" class="btn btn-info">
                                    Show
                                </a>
                                <a href="/edit/<?= $task['task_id']; ?>" class="btn btn-warning">
                                    Edit
                                </a>
                                <a onclick="return confirm('are you sure?');" href="/delete/<?= $task['task_id']; ?>"
                                   class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
