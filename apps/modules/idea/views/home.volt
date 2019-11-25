{% extends 'layout.volt' %}

{% block title %}Home{% endblock %}

{% block styles %}

{% endblock %}

{% block content %}
    {% if popup == 'success' %}
        <div class="alert alert-success" role="alert">
            {{popup_message}}
        </div>
    {% endif %}
    <ul>
        {% if ideas == null %}
            <h2 class="text-center mt-5">Be The First To Make A Great Idea <a href="{{ url('idea/add')}}">here</a></h2>
        {% endif %}
        {% for idea in ideas %}
            <li>
                <div class="sticky">
                    <h2>{{ idea.title() }}</h2>
                    <p> {{ idea.description() }}</p>
                    <div class="author">By {{ idea.author().name() }}</div>
                    <div class="email font-italic">({{ idea.author().email() }})</div>
                    <div class="rating">Ratings: {{ idea.averageRating() }}
                        <a href="{{ url('idea/rate/')}}{{idea.id().id()}}">Rate</a>
                    </div>
                    <div class="rating">Votes: {{ idea.votes() }}
                        {% if not in_array(idea.id().id(), votedIdeas) %}
                        <a href="{{ url('idea/vote/')}}{{idea.id().id()}}">Vote</a>
                        {% endif %}
                    </div>
                </div>
            </li>
        {% endfor %}
    </ul>
{% endblock %}

{% block scripts %}

{% endblock %}