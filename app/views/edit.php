<?php $this->layout('layout') ?>

<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Edit Task</h1>
            <?php if(isset($previousTask)):?>
                <form action="/update/<?= $previousTask['task_id']  ?>" method="post">
                    <div class="form-group">
                        <label>
                            <input type="text" name="title" class="form-control" value="<?= $previousTask['title'];?>">
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            <textarea name="content" class="form-control"><?= $previousTask['content'];?></textarea>
                        </label>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-warning" type="submit">Submit</button>
                    </div>
                </form>
            <?php endif;?>
            <a href="/main">Go Back</a>
        </div>
    </div>
</div>
