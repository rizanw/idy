{% extends 'layout.volt' %}

{% block title %}Rate Idea{% endblock %}

{% block styles %}

{% endblock %}

{% block content %}
<div class="container bg-white text-dark p-4 rounded">
    <h2>{{ idea.title() }}</h2>
    <div class="small">
        <span>By {{ idea.author().name() }}</span>
        <span class="font-italic">({{ idea.author().email() }})</span>
        <span>|</span>
        <span>Ratings: {{ idea.averageRating()}}</span>
        <span>Votes: {{ idea.votes() }}</span>
    </div>
    <p class="pt-3 pb-4"> {{ idea.description() }}</p>
</div>

<div class="container bg-white text-dark p-4 rounded" style="margin-top: 20px">
    <div class="h4 font-weight-bold"> Give Rating </div>
    <form method="POST" class="form-inline">
        <div class="form-group mr-2">
            <label class="font-weight-bold mx-1">Name</label>
            <input type="text" class="form-control" placeholder="Enter name" name="name">
        </div>
        <div class="form-group mr-2">
            <label class="font-weight-bold mx-1">Rating</label>
            <select class="form-control form-control-sm" name="rating">
                <option value=1 >1</option>
                <option value=2 >2</option>
                <option value=3 >3</option>
                <option value=4 >4</option>
                <option value=5 >5</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<div class="container mt-1">
  <div class="row">
    {% for rating in idea.ratings() %}
    <div class="col-sm-2 border border-dark text-dark bg-white rounded p-2">
        <div class="font-weight-bold">{{ rating.user() }}</div>
        Rating : {{ rating.value() }}
    </div>
    {% endfor %}
  </div>
</div>


{% endblock %}

{% block scripts %}

{% endblock %}