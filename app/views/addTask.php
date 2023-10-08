<?php $this->layout('layout') ?>

<style>
    <?php include "css/main.css" ?>
</style>

<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Create Task</h1>
            <form action="/storeTask" method="post">
                <div class="form-group">
                    <label for="title"></label><input id="title" type="text" class="form-control" name="title" required>
                </div>
                <div class="form-group">
                    <label for="content"></label><textarea id="content" name="content" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </form>
            <a href="/main">Go Back</a>
        </div>
    </div>
</div>
</body>
