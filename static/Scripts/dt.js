$(document).ready(function(){

    /** Отменяем стандартное действие при нажатии на ссылку */
	// $("#link").on('click', function(e){
    //     e.preventDefault();
    // })	

  //получаем subj выделенного элемента списка
  var subj = $("#list [class = active]").attr('subj');
  do_ajax(subj);

  $("#list li").on('click',function(event){
      event.preventDefault();
      $('#list li').removeClass("active");
      $(this).toggleClass("active");
    
      var subj = $(this).attr('subj');
      do_ajax(subj);
  });

  function do_ajax(subj)
  {
      $.ajax({
          url: "",
          type: "POST",
          data: {'act': "select_subject", 'subj': subj},
          cache: false
        }).done(function(msg){
            $('#right_part').html(msg);
        });
  }

  $('#apply, #run').on('click', function(e){
    e.preventDefault();
    var val  = ($(this).attr('value'));
    var code = cEditor.getValue();
    var lang = ($('#lang').val());
    var task_name = $('#task_name').val();
    $.ajax({
      url: "",
      type: "POST",
      data: {'act': "compile_this", 'val': val, 'code': code, 'lang': lang, 'task_name': task_name},
      cache: false
    }).done(function(msg){
      alert(msg);
    });
  });

  /** РЕГИСТРАЦИЯ */
    $('#do_reg').click(function(event){
      event.preventDefault();
      var formValid = true;

      $('#register_form input').each(function(){

          var formGroup = $(this).parents('.form-group');
          var glyphicon = formGroup.find('.form-control-feedback');

          if (!this.checkValidity())
          {
              formGroup.addClass('has-error').removeClass('has-success');
              glyphicon.addClass('glyphicon-remove').removeClass('glyphicon-ok');
              formValid = false;
          }
          else
          {
              formGroup.addClass('has-success').removeClass('has-error');
              glyphicon.addClass('glyphicon-ok').removeClass('glyphicon-remove'); 
          }
      });

      if (formValid)
      {
          var str = $('#register_form').serialize();
          str =  decodeURI(str);
          $.ajax({
              url: "",
              type: "POST",
              data: {'act': 'do_reg', 'str': str},
              cache: false
          }).done(function(msg){
              if (msg == 0)                        
              {
                  $('#pass-danger').removeClass('hidden');
                  hide_input_icons();
              }
              if (msg == 1)
              {
                  $('#login-danger').removeClass('hidden');
                  hide_input_icons();
              }
              if (msg == 2)
              {
                  alert("Проблемы при вставке значений");
              }
              if (msg == 1000)
              {
                  window.location.href = "?act=login";
              }
          })
      }

      // скрываем значки в инпутах формы
      function hide_input_icons()
      {
          $('#register_form input').each(function() 
          {
              var formGroup = $(this).parents('.form-group');
              var glyphicon = formGroup.find('.form-control-feedback');
              formGroup.removeClass('has-success');
              glyphicon.removeClass('glyphicon-ok');
          });
      }
    });
    /** РЕГИСТРАЦИЯ КОНЕЦ */
    
    /** МЕНЯЕМ ЯЗЫК И ПОДКЛЮЧАЕМ НУЖНЫЙ СНИППЕТ */
    $('#lang').on('change', function()
    {
        var lang = $(this).val();
        if (lang == "c")
            cEditor.setOption("mode", "text/x-csrc");
        if (lang == "sharp")
            cEditor.setOption("mode", "text/x-csharp");
        // подгружаем файл сниппета
        $.ajax({
            url: "",
            type: "POST",
            data: {'act': 'change_lang', 'lang': lang},
            cache: false
        }).done(function(answ){
            cEditor.setValue(answ);
        })
    });
    /** КОНЕЦ МЕНЯЕМ ЯЗЫК И ПОДКЛЮЧАЕМ НУЖНЫЙ СНИППЕТ */

  /** CODEMIRROR */
    var cEditor = CodeMirror.fromTextArea(document.getElementById("c-code"), {
        matchBrackets: true,
        theme: "dracula",
        keyMap: "default",
        lineNumbers: true,
        matchBrackets: true,
        mode: "text/x-csrc",
      });

      $('#keymap').on('change', function()
      {
          var mod = $(this).val();
          if (mod == 0)
            cEditor.setOption("keyMap", "default");
          if (mod == 1)
            cEditor.setOption("keyMap", "vim");           
      });

      var commandDisplay = document.getElementById('command-display');
      var keys = '';
      CodeMirror.on(editor, 'vim-keypress', function(key) {
        keys = keys + key;
        commandDisplay.innerHTML = keys;
      });
      CodeMirror.on(editor, 'vim-command-done', function(e) {
        keys = '';
        commandDisplay.innerHTML = keys;
      });
});
