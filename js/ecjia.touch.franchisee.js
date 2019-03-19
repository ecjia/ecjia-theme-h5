/**
 * 后台综合js文件
 */
;
(function (ecjia, $) {
	ecjia.touch.franchisee = {
		init: function () {
			ecjia.touch.franchisee.validate_code();
			ecjia.touch.franchisee.next();
			ecjia.touch.franchisee.enter_code();
			ecjia.touch.franchisee.resend_sms();

			$('.process_search').off('click').on('click', function () {
				var url = $(this).attr('data-url'),
					info = {
						'f_mobile': $("input[name='f_mobile']").val(),
						'f_code': $("input[name='f_code']").val()
					};
				$.post(url, info, function (data) {
					$('.la-ball-atom').remove();
					if (data.state == 'error') {
						alert(data.message);
					} else if (data.state == 'success') {
						location.href = data.url;
					}
				});
			});
		},

		//商家入驻流程获取验证码
		validate_code: function () {
			var InterValObj; //timer变量，控制时间
			var count = 60; //间隔函数，1秒执行
			var curCount; //当前剩余秒数

			$(".settled-message").on('click', function (e) {
				e.preventDefault();
				var url = $(this).attr('data-url');
				var mobile = $("input[name='f_mobile']").val();
				if (mobile.length == 11) {
					url += '&mobile=' + mobile;
				} else {
					alert(js_lang.please_enter_correct_tel);
					return false;
				}

				$.get(url, function (data) {
					if (data.state == 'error') {
						var myApp = new Framework7();
						myApp.modal({
							title: js_lang.prompt,
							text: data.message,
							buttons: [{
								text: js_lang.cancel,
								onClick: function () {
									return false;
								}
							}, {
								text: js_lang.view_progress,
								onClick: function () {
									$('.modal').remove();
									$('.modal-overlay').remove();
									$(".ecjia-store-goods .a1n .a1x").css({
										overflow: "auto"
									}); //启用滚动条
									$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
									if (typeof (data.search_url) != 'undefined') {
										location.href = data.search_url;
									}
									return false;
								}
							}, ]
						});
					}
					if (data.state == 'success') {　
						curCount = count;
						$("#mobile").attr("readonly", "true");
						$("#get_code").attr("disabled", "true");
						$("#get_code").css("width", "7em");
						$("#get_code").css("right", "4%");
						$("#get_code").css("position", "absolute");
						$("#get_code").css("padding", "0");
						$("#get_code").css("margin", "0");
						$("#get_code").css("top", ".5em");
						$("#get_code").css("height", "2.2em");
						$("#get_code").val(sprintf(js_lang.resend_second, curCount));
						$("#get_code").attr("class", "btn btn-org login-btn settled-message btn-small");
						InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
					}
					ecjia.touch.showmessage(data);
				});

				//timer处理函数
				function SetRemainTime() {
					if (curCount == 0) {
						window.clearInterval(InterValObj); //停止计时器
						$("#mobile").removeAttr("readonly"); //启用按钮
						$("#get_code").removeAttr("disabled"); //启用按钮
						$("#get_code").val(js_lang.resend);
						$("#get_code").attr("class", "btn btn-info login-btn btn-small settled-message");
					} else {
						curCount--;
						$("#get_code").attr("disabled", "true");
						$("#get_code").val(sprintf(js_lang.resend_second, curCount));
					}
				};
			});
		},

		//入驻页面下一步
		next: function () {
			$("input[name='next_button']").on('click', function (e) {
				e.preventDefault();
				var f_name = $("input[name='f_name']").val();
				var f_email = $("input[name='f_email']").val();
				var f_mobile = $("input[name='f_mobile']").val();
				var f_code = $("input[name='f_code']").val();
				var url = $("form[name='theForm']").attr('action');

				if (f_name == '') {
					alert(js_lang.please_enter_name);
					return false;
				}

				if (f_email == '') {
					alert(js_lang.please_enter_email);
					return false;
				} else {
					var search_str = /^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/;
					if (!search_str.test(f_email)) {
						alert(js_lang.please_enter_correct_email);
						return false;
					}
				}

				if (f_mobile == '') {
					alert(js_lang.please_enter_tel);
					return false;
				}

				if (f_code == '') {
					alert(js_lang.verification_filled);
					return false;
				}

				var referer_url = $('input[name="referer_url"]').val();
				var info = {
					'f_name': f_name,
					'f_email': f_email,
					'f_mobile': f_mobile,
					'f_code': f_code
				};
				$.post(url, info, function (data) {
					if (data.state == 'error') {
						alert(data.message);
					} else {
						if (typeof (data.url) != 'undefined') {
							location.href = data.url;
						}
					}
				});
			});

			$('.franchisee-captcha-refresh').off('click').on('click', function (e) {
				var url = $(this).attr('data-url');
				$.post(url, function (data) {
					if (data.state == 'error') {
						ecjia.touch.showmessage(data);
						return false;
					}
					$('.franchisee-img-captcha').find('img').attr('src', 'data:image/png;base64,' + data.message);
				});
			});

			$('.resend_sms').off('click').on('click', function () {
				var $this = $(this),
					url = $this.attr('data-url');
				if ($this.hasClass('disabled')) {
					return false;
				}
				$.post(url, {
					'type': 'resend'
				}, function (data) {
					ecjia.touch.showmessage(data);
				});
			});
		},

		resend_sms: function () {
			var InterValObj; //timer变量，控制时间
			var count = 60; //间隔函数，1秒执行
			var curCount; //当前剩余秒数
			curCount = count;
			$(".resend_sms").addClass("disabled");
			InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
			$(".resend_sms").html(sprintf(js_lang.check_second, curCount));
			
			//timer处理函数
			function SetRemainTime() {
				if (curCount == 0) {
					window.clearInterval(InterValObj); //停止计时器
					$(".resend_sms").removeClass("disabled"); //启用按钮
					$(".resend_sms").html(js_lang.resend);
				} else {
					curCount--;
					$(".resend_sms").html(sprintf(js_lang.check_second, curCount));
				}
			};
		},

		enter_code: function () {
			var $input = $(".franchisee_pass_container input");
			$(".franchisee_pass_container input").on("input", function () {
				var val = $(this).val();
				if (val == '') {
					var index = parseInt($(this).index()) - 1;
					if (index < 0) {
						index = 0;
					}
					$(this).blur();
					$input.eq("" + index + "").focus();
				} else {
					var index = parseInt($(this).index()) + 1;
					$(this).blur();
					$input.eq("" + index + "").focus();
				}
				var value = '';
				$input.each(function () {
					value += $(this).val();
				})
				if (value.length == 6) {
					var type = $('input[name="type"]').val();
					var mobile = $('input[name="mobile"]').val();
					var url = $('input[name="url"]').val();

					var info = {
						'type': type,
						'value': value,
						'mobile': mobile
					}
					$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
					$.post(url, info, function (data) {
						$('.la-ball-atom').remove();
						if (data.state == 'error') {
							alert(data.message);
						} else if (data.state == 'success') {
							location.href = data.url;
						}
					})
					return false;
				}
			});
		},

		//入驻页面下一步
		second: function () {
			$("input[name='franchisee_submit']").on('click', function (e) {
				e.preventDefault();
				var seller_name = $("input[name='seller_name']").val();
				var seller_category = $("input[name='seller_category']").val();
				var seller_category_name = $("input[name='seller_category_name']").val();
				var validate_type = $("input[name='validate_type']").val();
				var province = $("input[name='f_province']").val();
				var city = $("input[name='f_city']").val();
				var district = $("input[name='f_district']").val();
				var street = $("input[name='f_street']").val();
				var address = $("input[name='f_address']").val();
				var longitude = $("input[name='longitude']").val();
				var latitude = $("input[name='latitude']").val();
				var mobile = $("input[name='mobile']").val();
				var code = $("input[name='code']").val();

				$.cookie('franchisee_province_name', $("input[name='f_province_name']").val(), {
					expires: 7
				});
				$.cookie('franchisee_city_name', $("input[name='f_city_name']").val(), {
					expires: 7
				});
				$.cookie('franchisee_district_name', $("input[name='f_district_name']").val(), {
					expires: 7
				});
				$.cookie('franchisee_street_name', $("input[name='f_street_name']").val(), {
					expires: 7
				});
				$.cookie('franchisee_seller_category_id', $("input[name='seller_category']").val(), {
					expires: 7
				});
				$.cookie('franchisee_seller_category', $("input[name='seller_category_name']").val(), {
					expires: 7
				});
				$.cookie('franchisee_address', address, {
					expires: 7
				});
				$.cookie('franchisee_seller_name', seller_name, {
					expires: 7
				});
				var url = $("form[name='theForm']").attr('action');
				if (seller_name == '') {
					alert(js_lang.please_store_name);
					return false;
				}
				if (seller_category == '') {
					alert(js_lang.please_select_store_category);
					return false;
				}
				if (validate_type == '') {
					alert(js_lang.please_select_type);
					return false;
				}
				if (province == '') {
					alert(js_lang.please_select_province);
					return false;
				}
				if (city == '') {
					alert(js_lang.please_select_city);
					return false;
				}
				if (district == '') {
					alert(js_lang.please_select_area);
					return false;
				}
				if (street == '') {
					alert(js_lang.please_select_street);
					return false;
				}
				if (address == '') {
					alert(js_lang.please_address);
					return false;
				}
				if (longitude == '' || latitude == '') {
					alert(js_lang.please_get_store_coordinates);
					return false;
				}

				var info = {
					'seller_name': seller_name,
					'seller_category': seller_category,
					'seller_category_name': seller_category_name,
					'validate_type': validate_type,
					'province': province,
					'city': city,
					'district': district,
					'street': street,
					'address': address,
					'longitude': longitude,
					'latitude': latitude,
					'mobile': mobile,
					'code': code
				};
				$.post(url, info, function (data) {
					if (data.state == 'error') {
						alert(data.message);
					} else {
						if (typeof (data.url) != 'undefined') {
							location.href = data.url;
						}
					}
				});
			});
			ecjia.touch.franchisee.choose_pcd();
			ecjia.touch.franchisee.choose_street();
		},

		choose_pcd: function () {
			var province = $("input[name='province_list']").val();
			var city = $("input[name='city_list']").val();
			var district = $("input[name='district_list']").val();

			var clear = $("input[name='clear']").val();
			if (clear == 1) {
				sessionStorage.removeItem('franchisee_province_id');
				sessionStorage.removeItem('franchisee_province_name');
				sessionStorage.removeItem('franchisee_city_id');
				sessionStorage.removeItem('franchisee_city_name');
				sessionStorage.removeItem('franchisee_district_id');
				sessionStorage.removeItem('franchisee_district_name');
				sessionStorage.removeItem('franchisee_street_id');
				sessionStorage.removeItem('franchisee_street_name');
			} else {
				var temp_province_id = sessionStorage.getItem('franchisee_province_id');
				if (temp_province_id != null) {
					$('input[name="f_province"]').val(temp_province_id);
				}
				var temp_city_id = sessionStorage.getItem('franchisee_city_id');
				if (temp_city_id != null) {
					$('input[name="f_city"]').val(temp_city_id);
				}
				var temp_district_id = sessionStorage.getItem('franchisee_district_id');
				if (temp_district_id != null) {
					$('input[name="f_district"]').val(temp_district_id);
				}
				var temp_street_id = sessionStorage.getItem('franchisee_street_id');
				if (temp_street_id != null) {
					$('input[name="f_street"]').val(temp_street_id);
				}

				var val = '';
				var temp_province_name = sessionStorage.getItem('franchisee_province_name');
				if (temp_province_name != null) {
					$('input[name="f_province_name"]').val(temp_province_name);
					val += temp_province_name;
				}
				var temp_city_name = sessionStorage.getItem('franchisee_city_name');
				if (temp_city_name != null) {
					$('input[name="f_city_name"]').val(temp_city_name);
					val += '-' + temp_city_name;
				}
				var temp_district_name = sessionStorage.getItem('franchisee_district_name');
				if (temp_district_name != null) {
					$('input[name="f_district_name"]').val(temp_district_name);
					val += '-' + temp_district_name;
				}
				if (val != '') {
					$('.ecjia-franchisee-location-pcd').html(val);
				}
				var temp_street_name = sessionStorage.getItem('franchisee_street_name');
				if (temp_street_name != null) {
					$('input[name="f_street_name"]').val(temp_street_name);
					$('.ecjia-franchisee-location-street').html(temp_street_name);
				}
			}

			if ($.localStorage('franchisee_province') == undefined) {
				$.localStorage('franchisee_province', province);
			}
			if ($.localStorage('franchisee_city') == undefined) {
				$.localStorage('franchisee_city', city);
			}
			if ($.localStorage('franchisee_district') == undefined) {
				$.localStorage('franchisee_district', district);
			}
			var data = region_data('', '', '');

			var province_list = data[0];
			var province_list_name = data[1];
			var city_list = data[2];
			var city_list_name = data[3];
			var district_list = data[4];
			var district_list_name = data[5];

			var url = $('#get_location_region').attr('data-url');
			var myApp = new Framework7();

			var pickerCustomToolbar = myApp.picker({
				input: '.ecjia-franchisee-location-pcd',
				cssClass: 'ecjia-franchisee-pcd-picker',
				formatValue: function (p, values, displayValues) {
					return displayValues[0] + '-' + displayValues[1] + '-' + displayValues[2];
				},
				toolbarTemplate: '<div class="toolbar">' +
					'<div class="toolbar-inner">' +
					'<div class="left">' +
					'<a href="javascript:;" class="link close-picker external">'+ js_lang.cancel +'</a>' +
					'</div>' +
					'<div class="right">' +
					'<a href="javascript:;" class="link save-picker external">'+ js_lang.finish +'</a>' +
					'</div>' +
					'</div>' +
					'</div>',
				cols: [{
						values: province_list,
						displayValues: province_list_name,
						onChange: function (picker, value) {
							var data = region_data(value, '', '');
							if (picker.cols[1].replaceValues) {
								picker.cols[1].replaceValues(data[2], data[3]);
							}
							if (picker.cols[2].replaceValues) {
								picker.cols[2].replaceValues(data[4], data[5]);
							}
						}
					},
					{
						values: city_list,
						displayValues: city_list_name,
						onChange: function (picker, value) {
							var data = region_data('', value, '');
							if (picker.cols[2].replaceValues) {
								picker.cols[2].replaceValues(data[4], data[5]);
							}
						}
					},
					{
						values: district_list,
						displayValues: district_list_name
					},
				],
				onOpen: function (picker) {
					var province = $('input[name="f_province"]').val();
					var city = $('input[name="f_city"]').val();
					var district = $('input[name="f_district"]').val();
					picker.setValue([province, city, district]); //设置选中值

					picker.container.find('.save-picker').on('click', function () {
						var district_value = $('input[name="f_district"]').val();
						var col0 = picker.cols[0].container.find('.picker-selected');
						var col1 = picker.cols[1].container.find('.picker-selected');
						var col2 = picker.cols[2].container.find('.picker-selected');
						var html = col0.html();
						if (col1.html() != '暂无') {
							html += '-' + col1.html();
						}
						if (col2.html() != '暂无') {
							html += '-' + col2.html();
						}
						$('.ecjia-franchisee-location-pcd').html(html);

						$('input[name="f_province_name"]').val(col0.html());
						$('input[name="f_city_name"]').val(col1.html());
						$('input[name="f_district_name"]').val(col2.html());

						var col0Value = col0.attr('data-picker-value');
						var col1Value = col1.attr('data-picker-value');
						var col2Value = col2.attr('data-picker-value');
						$('input[name="f_province"]').val(col0Value);
						$('input[name="f_city"]').val(col1Value);
						$('input[name="f_district"]').val(col2Value);

						if (district_value != col2Value) {
							$('.ecjia-franchisee-location-street').html(js_lang.please_street);
							$('input[name="f_street"]').val('');
							$('input[name="f_street_name"]').val('');
						}
						$.post(url, {
							district_id: col2Value
						}, function (data) {
							$('input[name="street_list"]').val(data.street_list);
							var key = 'franchisee_street_' + col2Value;
							$.localStorage(key, data.street_list);
						});
						var temp_data = {
							'franchisee_province_id': col0Value,
							'franchisee_province_name': col0.html(),
							'franchisee_city_id': col1Value,
							'franchisee_city_name': col1.html(),
							'franchisee_district_id': col2Value,
							'franchisee_district_name': col2.html(),
						};
						save_temp(temp_data);
						picker.close();
						$('.modal-overlay').remove();
					});
					picker.container.find('.close-picker').on('click', function () {
						picker.close();
						$('.modal-overlay').remove();
					});
				},
				onClose: function (picker) {
					picker.close();
					$('.modal-overlay').remove();
				}
			});

			$('.ecjia-franchisee-location-street').off('click').on('click', function () {
				var province = $('input[name="f_province"]').val();
				var city = $('input[name="f_city"]').val();
				var district = $('input[name="f_district"]').val();
				if (province == '' || city == '' || district == '') {
					alert(js_lang.please_street_region);
					return false;
				}
			});
		},

		choose_street: function () {
			var App = new Framework7();
			var pickerStreetToolbar = App.picker({
				input: '.ecjia-franchisee-location-street',
				cssClass: 'ecjia-franchisee-street-picker',
				formatValue: function (p, values, displayValues) {
					return displayValues[0];
				},
				toolbarTemplate: '<div class="toolbar">' +
					'<div class="toolbar-inner">' +
					'<div class="left">' +
					'<a href="javascript:;" class="link close-picker external">'+ js_lang.cancel +'</a>' +
					'</div>' +
					'<div class="right">' +
					'<a href="javascript:;" class="link save-picker external">'+ js_lang.finish +'</a>' +
					'</div>' +
					'</div>' +
					'</div>',
				cols: [{
					values: [''],
					displayValues: [js_lang.please_where_street],
				}, ],
				onOpen: function (picker) {
					var district = $('input[name="f_district"]').val();
					var key = 'franchisee_street_' + district;
					if ($.localStorage(key) == undefined) {
						var street_list = $("input[name='street_list']").val();
						$.localStorage(key, street_list);
					}
					var data = region_data('', '', district);
					picker.cols[0].replaceValues(data[6], data[7]);
					var street = $('input[name="f_street"]').val();
					picker.setValue([street]); //设置选中值

					picker.container.find('.save-picker').on('click', function () {
						var col0 = picker.cols[0].container.find('.picker-selected');
						var col0Value = col0.attr('data-picker-value');
						if (col0Value.length != 0) {
							var html = col0.html();
							$('input[name="f_street_name"]').val(html);
							$('.ecjia-franchisee-location-street').html(html);
							$('input[name="f_street"]').val(col0Value);
							var temp_data = {
								'franchisee_street_id': col0Value,
								'franchisee_street_name': html
							};
							save_temp(temp_data);
						}
						picker.close();
						$('.modal-overlay').remove();
					});
					picker.container.find('.close-picker').on('click', function () {
						picker.close();
						$('.modal-overlay').remove();
					});
				},
				onClose: function (picker) {
					picker.close();
					$('.modal-overlay').remove();
				}
			});
		},

		//店铺入驻选择分类、入驻类型、店铺所在地
		choices: function () {
			//更新店铺名
			var myApp = new Framework7();
			$('input[name="seller_name"]').blur(function () {
				$.cookie('franchisee_seller_name', $('input[name="seller_name"]').val(), {
					expires: 7
				});
			});

			var category_list = [];
			var category = eval('(' + $("input[name='category']").val() + ')')['data'];
			if (category == null) {
				$("input[name='seller_category']").val(js_lang.temporarily_cat);
				$.cookie('franchisee_seller_category_id', '', {
					expires: 7
				});
			} else {
				for (i = 0; i < category.length; i++) {
					category_list.push(category[i]['name']);
				};
				var pickerDevice = myApp.picker({
					input: '.ecjia-franchisee-category',
					toolbarCloseText: js_lang.finish,
					cols: [{
						onChange: function (p, value) {
							$.cookie('franchisee_seller_category', value, {
								expires: 7
							});
							for (i = 0; i < category.length; i++) {
								if (category[i]['name'] == value) {
									$.cookie('franchisee_seller_category_id', category[i]['id'], {
										expires: 7
									});
									$("input[name='seller_category']").val(category[i]['id']);
								}
							}
						},
						textAlign: 'center',
						values: category_list
					}]
				});
			}

			var category_test = $(".picker-selected").attr("data-picker-value");
			var pickerDevice = myApp.picker({
				input: '.ecjia-franchisee-type',
				toolbarCloseText: js_lang.finish,
				cols: [{
					textAlign: 'center',
					values: [js_lang.individual_settlement, js_lang.enterprise_settled],
					onChange: function (p, value) {
						$.cookie('franchisee_validate_type', value, {
							expires: 7
						});
					}
				}]
			});

		},


		//传参到获取精准坐标页
		coordinate: function () {
			var longitude = $("input[name='longitude']").val();
			var latitude = $("input[name='latitude']").val();
			var mobile = $("input[name='mobile']").val();
			var code = $("input[name='code']").val();
			if (longitude != '' && latitude != '') {
				$(".coordinate").html(sprintf(js_lang.longitude_latitude, longitude, latitude));
			}

			$(".coordinate").on('click', function (e) {
				var seller_name = $("input[name='seller_name']").val();
				$.cookie('franchisee_seller_name', seller_name, {
					expires: 7
				});
				var f_province = $("input[name='f_province_name']").val();
				var f_city = $("input[name='f_city_name']").val();
				var f_district = $("input[name='f_district_name']").val();
				var f_street = $("input[name='f_street_name']").val();
				var f_address = $("input[name='f_address']").val();

				$.cookie('franchisee_address', f_address, {
					expires: 7
				});
				if (f_province && f_district && f_district && f_address && f_street) {
					var url = $(this).attr("data-url");
					var url = url + '&province=' + f_province + '&city=' + f_city + '&district=' + f_district + '&street=' + f_street + '&address=' + f_address + '&mobile=' + mobile + '&code=' + code;
					location.href = url;
				} else {
					alert(js_lang.please_select_province_city);
				}
			})
		},

		location: function () {
			$("#button").on('click', function (e) {
				e.preventDefault();
				var longitude = $("input[name='longitude']").val();
				var latitude = $("input[name='latitude']").val();
				var mobile = $("input[name='mobile']").val();
				var code = $("input[name='code']").val();
				var url = $(this).attr("data-url") + '&longitude=' + longitude + '&latitude=' + latitude + '&mobile=' + mobile + '&code=' + code;
				location.href = url;
			})
		},

		//撤销申请
		cancel_apply: function () {
			$('input[name="cancel"]').on('click', function (e) {
				e.preventDefault();
				var url = $(this).attr('data-url');
				options = {
					'status': 'cancel',
				}
				var myApp = new Framework7({
					modalButtonCancel: js_lang.cancel,
					modalButtonOk: js_lang.ok,
					modalTitle: js_lang.prompt
				});
				myApp.confirm(js_lang.cancel_application, function () {
					$.post(url, options, function (data) {
						if (data.log != '') {
							ecjia.pjax(data.cancel_url);
						}
					});
				});

			});
		},
	};

	//处理地区数据
	function region_data(province_id, city_id, district_id) {
		var province = eval($.localStorage('franchisee_province'));
		var city = eval($.localStorage('franchisee_city'));
		var district = eval($.localStorage('franchisee_district'));
		var street = eval($.localStorage('franchisee_street_' + district_id));

		var province_value = [];
		var province_display_value = [];
		if (district_id == '') {
			for (i = 0; i < province.length; i++) {
				var name = province[i]['name'];
				var id = province[i]['id'];
				province_value.push(id);
				province_display_value.push(name);
			};
		}
		if (province_id == '') {
			province_id = province_value[0];
		}

		var city_value = [];
		var city_display_value = [];
		if (district_id == '') {
			for (i = 0; i < city.length; i++) {
				if (city[i]['parent_id'] == province_id) {
					var name = city[i]['name'];
					var id = city[i]['id'];
					city_value.push(id);
					city_display_value.push(name);
				}
			};
		}
		if (city_id == '') {
			city_id = city_value[0];
		}
		var district_value = [];
		var district_display_value = [];
		if (district_id == '') {
			for (i = 0; i < district.length; i++) {
				if (district[i]['parent_id'] == city_id) {
					var name = district[i]['name'];
					var id = district[i]['id'];
					district_value.push(id);
					district_display_value.push(name);
				}
			};
		}

		if (district_id == '') {
			district_id = district_value[0];
		}

		var street_value = [];
		var street_display_value = [];
		if (street != undefined) {
			for (i = 0; i < street.length; i++) {
				if (street[i]['parent_id'] == district_id) {
					var name = street[i]['name'];
					var id = street[i]['id'];
					street_value.push(id);
					street_display_value.push(name);
				}
			};
		}
		if (district_value.length == 0 || district_display_value.length == 0) {
			district_value = [''];
			district_display_value = [js_lang.temporarily_no];
		}
		if (street_value.length == 0 || street_display_value.length == 0) {
			street_value = [''];
			street_display_value = [js_lang.temporarily_no];
		}
		return [province_value, province_display_value, city_value, city_display_value, district_value, district_display_value, street_value, street_display_value];
	}

	function save_temp(arr) {
		for (var i in arr) {
			sessionStorage.setItem(i, arr[i]);
			if (arr['franchisee_street_id'] == undefined) {
				sessionStorage.removeItem('franchisee_street_id');
				sessionStorage.removeItem('franchisee_street_name');
			}
		}
	}

})(ecjia, jQuery);

//end