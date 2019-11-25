{% extends 'layout.volt' %}

{% block title %}Add New Idea{% endblock %}

{% block styles %}
    
{% endblock %}

{% block content %}
<div class="container-fluid">
    <form method="POST">
        <h3>Author</h3>
        <div class="form-group">
            <label class="font-weight-bold">Name</label>
            <input type="text" class="form-control" placeholder="Enter name" name="author_name">
        </div>
        <div class="form-group">
            <label class="font-weight-bold">Email</label>
            <input type="email" class="form-control" placeholder="Enter email" name="author_email">
        </div>
        <h3>Idea</h3>
        <div class="form-group">
            <label class="font-weight-bold">Title</label>
            <input type="text" class="form-control" placeholder="Enter title" name="idea_title">
        </div>
        <div class="form-group">
            <label class="font-weight-bold">Description</label>
            <textarea type="text" rows="5" class="form-control" placeholder="Description" name="idea_description"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>


{% endblock %}

{% block scripts %}

{% endblock %}