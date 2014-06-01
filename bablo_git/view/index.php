<?php session_start(); ?>
<?php


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Предоставь e-mail - получи расширенный сервис");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "N");
$APPLICATION->SetTitle("Форма обратной связи");
?> 
<script src="/javascript/jquery.validate.min.js" type="text/javascript"></script>
<script>
$().ready(function() {
	// validate signup form on keyup and submit
	$("#qform").validate({
		submitHandler: function(form) {
			var postData = $(form).serialize();
			$.post("/ajax_addmail.php", postData,function(data) {
				if(data.type=="success"){
					$('#qform').trigger( 'reset' );
					$('.form_success').show();
				}
                else if (data.type="captchaerror") {
                    
                    $('.form_error').show();
                  
                    
                }
			},"json");
		},
		rules: {
			firstname: "required",
			lastname: "required",
			lastname2: "required",
			phone: "required",
			email: {
				required: true,
				email: true
			},
			question: "required"
		},
		messages: {
			firstname: "Пожалуйста, введите Ваше имя",
			lastname: "Пожалуйста, введите Вашу фамилию",
			lastname2: "Пожалуйста, введите Ваше отчество",
			phone: "Пожалуйста, введите Ваш номер телефона",
			email: "Пожалуйста, введите действительный адрес электронной почты",
			question: "Пожалуйста, введите текст Вашего вопроса"
		}
	});
});
</script>

<div class="description">
			<div class = "form_success" style="display:none; padding:3px; background:#9cffac;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;">Спасибо за обращение, Ваши данные внесены в базу</div>
            <form id="qform" action="" class="feedback_form">
				<h1>Получить расширенный сервис</h1>
				<p><br /></p>

					<h3>Зарегистрируйте свой электронный адрес и воспользуйтесь преимуществами новых сервисов:</h3>
				<br/>
<ul style="list-style-type:disc; padding-left:15px;">

<li>Получайте квитанции для оплаты платежей</li>
<li>Получайте информацию об индексации по e-mail</li>
<li>Получайте информацию об инвестиционном доходе быстрее</li>
<li>Узнавайте о важнейших новости компании</li>
<li>Пользуйтесь Вашим «Персональным кабинетом»</li>
				

				</ul>

				<p><br/>Для регистрации Вашего e-mail необходимо заполнить форму ниже.<br/></p>
 <p><br/>AEGON гарантирует, что предоставленная Вами персональная информация не будет передана третьим лицам или использована как-то иначе, чем для оповещения Вас о состоянии Вашего договора, новостях и предложениях компании.</p>

				<div class="desc_item">
					
                    <fieldset>
                        <label class="form_lb">Фамилия*</label>
                        <input name="lastname" type="text" value="" class="styled_input" />
                    </fieldset>
                    <fieldset>
                        <label class="form_lb">Имя*</label>
                        <input name="firstname" type="text" value="" class="styled_input" />
                    </fieldset>
                    <fieldset>
                        <label class="form_lb">Отчество*</label>
                        <input  name="lastname2" type="text" value="" class="styled_input" />
                    </fieldset>
					<fieldset>
                        <label class="form_lb">Телефон*</label>
                        <input  name="phone" type="text" value="" class="styled_input" />
                    </fieldset>
					<fieldset>
                        <label class="form_lb">Email*</label>
                        <input  name="email" type="text" value="" class="styled_input" />
                    </fieldset>
                    
                    
                    <label class="form_lb">Предпочтительный язык общения</label>
                    <select name="language" id="language" style="width:269px;" >
                        <option value="russian">Русский</option>
                        <option value="ukrainian">Українська</option>
                        <option value="english">English</option>
                    
                    
                    
                    
                    </select>
                    
               <img src="/upload/coolcaptcha/captcha.php" id="captcha" /><br/>     
                   <a href="#" onclick="
    document.getElementById('captcha').src='/upload/coolcaptcha/captcha.php?'+Math.random();
    document.getElementById('captcha-form').focus();"
    id="change-image">Не можете прочесть? </a><br/><br/>



<input type="text" name="captcha" id="captcha-form" autocomplete="off" /><br/>
         <label class="error form_error" style="display:none;">Неправильно введен проверочный код</label>           
				   
				</div>
               
              
               <div class = "form_success" style="display:none; padding:3px; background:#9cffac;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;">Спасибо за обращение, Ваши данные внесены в базу</div>
                    <fieldset>
                        <label class="form_lb">Поля, отмеченные *, обязательны для заполнения</label>

                        <input type="submit" id="submit_feedback" class="submit_btn" value="Получить сервис" />
                    </fieldset>

                </form>

			</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>