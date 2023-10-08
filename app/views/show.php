<?php $this->layout('layout') ?>

<style>
    h2, p, a {
        padding: 15px;
    }
</style>

<h2><?php echo $task['title']?></h2>
<p><?php echo $task['content']?></p>
<a href="/main">Go Back</a>
