
function Quiz(options)
{

    /*
     *  Default Options
     */

    this.options = {
        // target
        target: null,

        // quesion options
        current_question: 0,
        countdown: 10,              // every question countdown with seconds.

        // other
        waitScreenDelay: 5000,
        correct_answers:0
    };



    /*
     *  Messages
     */

    this.msg = {
        csrf_token_is_not_set: 'CSRF TOKEN is not set',
        target_is_not_set: 'target element is not set'
    };


    this.options = jQuery.extend(true, this.options, options);



    // Check & Verify options
    this._check = function()
    {
        // csrf token
        if(options.csrf_token == null)
        {
            console.log('%cError: ' + this.msg.csrf_token_is_not_set, 'color: red');
            return false;
        }

        // target
        if(options.target == null)
        {
            console.log('%cError: ' + this.msg.target_is_not_set, 'color: red');
            return false;
        }

        return true;
    };

    // Initialise options
    this._onInit = function()
    {
        // get subject id
        this.id = $(this.options.target).data('id');

        // spinner
        this.spinner = $('<div />', {
            'class': 'loader-container',
            'html': '<div class="loader"><svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg"' +
            ' x="0px" y="0px" width="40px" height="40px" viewBox="0 0' +
            ' 40 40" enable-background="new 0 0 40 40" xml:space="preserve"> <path opacity="0.2" fill="#000"' +
            ' d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946' +
            ' s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z' +
            ' M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634' +
            ' c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,' +
            '26.626,31.749,20.201,31.749z"/><path fill="#000"' +
            ' d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0C22.32,' +
            '8.481,24.301,9.057,' +
            '26.013,10.047z"><animateTransform attributeType="xml" attributeName="transform" type="rotate" ' +
            'from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite"/></path></svg></div>'
        });

        return true;
    };

    // Construct & setup
    this._construct = function()
    {
        $(this.options.target).addClass('app-quiz');

        // show wait screen
        this._showWaitScreen();

        this._checkQuiz();
    };



    // Check Quiz
    this._checkQuiz = function ()
    {
        var self = this;

        var checkInterval = setInterval(function()
        {
            $.ajax({
                type: 'GET',
                url: '/api/quizzes/'+ self.id +'/check',
                headers: {'X-CSRF-TOKEN': csrf_token},
                success: function(result)
                {
                    if(result.quiz.is_started == 1)
                    {
                        if(result.user.is_started == 1)
                        {
                            clearInterval(checkInterval);
                            self._getQuestions();
                        }
                        else
                        {
                            self._removeWaitScreen();
                            self._showErrorScreen();
                        }
                    }
                }
            });

        }, 2000);
    };

    // Get Questions
    this._getQuestions = function()
    {
        $.ajax({
            type: 'POST',
            url: '/api/questions-with-answers',
            data: { id: this.id },
            headers: {'X-CSRF-TOKEN': this.options.csrf_token},
            success: function(result)
            {
                this.questions = result;

                this._removeWaitScreen();
                this._showQuizScreen();

                this._showNextQuestion();

            }.bind(this)
        });
    };

    // Show Next Question
    this._showNextQuestion = function()
    {
        if(this.questions[this.options.current_question] != undefined)
        {
            // progress current question
            // $('#quiz-progress-' + current_question).addClass('current');

            // show question
            $('#question').text(this.questions[this.options.current_question].question);

            // show answers
            this._showAnswers();

            // start quiz timer
            this._startTimer();
        }
        else
        {
            clearInterval(this.timer);

            this._removeQuizScreen();
            this._showResultsScreen();

            // when user is finished, send the results
            this._sendResults();
        }
    };

    // Show The Answers
    this._showAnswers = function()
    {
        $('#answers').html('');

        var self = this;

        for (var i = 0; i < this.questions[this.options.current_question].answers.length; i++)
        {
            var answer = $('<button />', {
                'class': 'btn btn-default btn-block',
                'html': '<span>'+ (i+1) +'</span>' +
                this.questions[this.options.current_question].answers[i].answer
            })
                .on('click', function()
                {
                    var is_correct = $(this).data('is_correct');

                    if(is_correct)
                    {
                        self.options.correct_answers++;
                        $(this).addClass('btn-success');
                        // $('#quiz-progress-' + this.current_question).addClass('success');
                    }
                    else
                    {
                        $(this).addClass('btn-danger');
                        // $('#quiz-progress-' + current_question).addClass('error');
                    }

                    $('.answers > button').prop('disabled', true);
                });

            answer.data('is_correct', this.questions[this.options.current_question].answers[i].is_correct);
            answer.appendTo('#answers');
        }
    };

    // start quiz timer
    this._startTimer = function()
    {
        var count = this.options.countdown;

        var timer = setInterval(function ()
        {
            if(count < 0)
            {
                clearInterval(timer);
                count = this.options.countdown;
                this.options.current_question++;
                this._showNextQuestion();
            }

            $('#timer').html('00:' + count);
            count--;

        }.bind(this), 1000);
    };

    // Send The Results
    this._sendResults = function()
    {
        $.ajax({
            type: 'POST',
            url: '/ajax/subjects/save-results',
            data: {
                subject_id: this.subject_id,
                score: this.options.correct_answers +'/'+ this.questions.length
            },
            headers: {'X-CSRF-TOKEN': this.options.csrf_token},
            success: function(result)
            {
                if(result.success == 1)
                {
                    console.log('%cThe Quiz is finished Successfuly', 'color: green');
                }
                else
                {
                    console.log('%cThe Quiz is finished With Errors', 'color: red');
                }
            }
        });
    };

}


// start the quiz
Quiz.prototype.start = function ()
{
    this._check() && this._onInit() && this._construct();
};



/*
 *  QUIZ SCREENS
 */

// wait screen
Quiz.prototype._showWaitScreen = function()
{
    this.screen_wait = $('<section />', {
        'id': 'screen-wait',
        'style': 'display: none;'
    });

    var container = $('<div />', {
        'class': 'container text-center'
    });

    var text = $('<h3 />', {
        'class': 'text-muted',
        'text': 'Veuillez Patienter'
    });

    container.appendTo(this.screen_wait);
    text.appendTo(container);
    this.spinner.appendTo(container);
    this.screen_wait.appendTo(this.options.target).fadeIn();
};

// remove wait screen
Quiz.prototype._removeWaitScreen = function ()
{
    this.screen_wait.hide(function()
    {
        $(this).remove()
    })
};

// Quiz Screen
Quiz.prototype._showQuizScreen = function()
{
    this.screen_quiz = $('<section />', {
        'id': 'screen-quiz',
        'style': 'display: none;'
    });

    var container = $('<div />', { 'class': 'container' });

    var row = $('<div />', { 'class': 'row' });

    var col1 = $('<div />', { 'class': 'col-md-6' });

    var timer_container = $('<div />', {
        'class': 'text-center'
    });

    var timer = $('<span />', {
        'id': 'timer',
        'class': 'quiz-timer'
    });

    var choose_correct_answer = $('<h5 />', {
        'html': '<i class="fa fa-chevron-down"></i>&nbsp;Choose the correct answer'
    });

    var question = $('<h1 />', { 'id': 'question' });

    var col2 = $('<div />', { 'class': 'col-md-6' });

    var answers = $('<div />', {
        'id': 'answers',
        'class': 'answers'
    });

    this.screen_quiz.append(container);
    container.append(row);
    row.append(col1);
    col1.append(timer_container);
    timer_container.append(timer);
    col1.append(choose_correct_answer);
    col1.append(question);
    row.append(col2);
    col2.append(answers);

    this.screen_quiz.appendTo(this.options.target).fadeIn();
};

// remove quiz screen
Quiz.prototype._removeQuizScreen = function ()
{
    this.screen_quiz.hide(function()
    {
        $(this).remove()
    })
};

// Results Screen
Quiz.prototype._showResultsScreen = function()
{
    this.screen_results = $('<section />', {
        'id': 'screen-results',
        'style': 'display: none;'
    });

    var container = $('<div />', { 'class': 'container' });

    var row = $('<div />', { 'class': 'row' });

    var col1 = $('<div />', { 'class': 'col-md-6' });

    var panel = $('<div />', { 'class': 'panel panel-info' });

    var panel_heading = $('<div />', {
        'class': 'panel-heading',
        'html': '<h4>Vos Resultats</h4>'
    });

    var panel_body = $('<div />', {
        'class': 'panel-body',
        'html': '<h1>'+ this.options.correct_answers +'/'+ this.questions.length +'</h1>'
    });

    this.screen_results.append(container);
    container.append(row);
    row.append(col1);
    col1.append(panel);
    panel.append(panel_heading);
    panel.append(panel_body);

    this.screen_results.appendTo(this.options.target).fadeIn();
};

// error Screen
Quiz.prototype._showErrorScreen = function()
{
    $.ajax({
        type: 'GET',
        url: '/api/subjects/screen-error',
        success: function(result)
        {
            $(this.options.target).html(result);
        }.bind(this)
    });
};