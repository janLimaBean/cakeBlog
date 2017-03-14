<!--We use the FormHelper to generate the opening tag for an HTML form. Here’s the HTML that $this->Form->create() generates:

<form method="post" action="/articles/add">-->

<!--If create() is called with no parameters supplied, it assumes you are building a form that submits via POST to the current controller’s add() action (or edit() action when id is included in the form data).

The $this->Form->control() method is used to create form elements of the same name. The first parameter tells CakePHP which field they correspond to, and the second parameter allows you to specify a wide array of options - in this case, the number of rows for the textarea. There’s a bit of introspection and automagic here: control() will output different form elements based on the model field specified.

The $this->Form->end() call ends the form. Outputting hidden inputs if CSRF/Form Tampering prevention is enabled.-->

<h1>Add Article</h1>
<?php
    echo $this->Form->create($article);
    echo $this->Form->control('title');
    echo $this->Form->control('body', ['rows' => '3']);
    echo $this->Form->button(__('Save Article'));
    echo $this->Form->end();
?>