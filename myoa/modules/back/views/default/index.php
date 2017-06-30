<div class="back-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action <code>"<?= $this->context->action->id ?>"</code>.
        The action belongs to the controller <code>"<?= get_class($this->context) ?>"</code>
        in the <code>"<?= $this->context->module->id ?>"</code> module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
</div>
