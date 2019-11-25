{% extends 'layout.volt' %}

{% block title %}Rate Idea{% endblock %}

{% block styles %}

{% endblock %}

{% block content %}

<div class="sticky" style="margin-top:100px">
    <h2>{{ idea.title() }}</h2>
    <p> {{ idea.description() }}</p>
    <div class="author">By {{ idea.author().name() }}</div>
    <div class="email">{{ idea.author().email() }}</div>
    <div class="rating">Ratings: {{ idea.averageRating()}} <a href="{{ url('idea/rate/') }}{{ idea.id().id() }}">Rate</a></div>
    <div class="rating">Votes: {{ idea.votes() }} <a href="{{ url('idea/vote/') }}{{ idea.id().id() }}">Vote</a></div>
</div>

<div class="container bg-white text-dark p-2 rounded" style="margin-top: 20px">
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

<div class="container" style="margin-top:30px;">
  <div class="row">
    <!-- {% for rating in idea.ratings() %}
    <div class="col-sm-2 border border-dark text-dark bg-white rounded p-2">
        <div class="font-weight-bold">{{ rating.user() }}</div>
        Rating : {{ rating.value() }}
    </div>
    {% endfor %} -->
  </div>
</div>


{% endblock %}

{% block scripts %}

{% endblock %}