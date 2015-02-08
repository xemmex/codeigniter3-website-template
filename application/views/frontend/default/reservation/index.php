<section id="main" class="full-page">
    <div class="wrapper">
        <div class="col-left">

            <h2><?= tr ( '_PAGE_RESERVATION_WIZARD_title_' ); ?></h2>

            <form id="reservation_form" action="#" class="displayNone">

                <h3><?= tr ( '_PAGE_RESERVATION_WIZARD_step_one_title_' ); ?></h3>

                <fieldset>
                    <div class="sep mt20"><span></span></div>

                    <div class="alert notice"><?= tr ( '_PAGE_RESERVATION_WIZARD_step_one_help_' ); ?></div>

                    <div class="form-left-3">
                        <label for="wizard_date_from"><?= tr ( '_GLOBAL_date_from_' ); ?>: </label>
                        <input id="wizard_date_from" name="date_from" type="text" class="required" readonly="readonly" tabindex="1">
                    </div>
                    <div class="form-left-3">

                        <label for="wizard_date_to"><?= tr ( '_GLOBAL_date_to_' ); ?>:</label>
                        <input id="wizard_date_to" name="date_to" type="text" class="required" readonly="readonly" tabindex="2">
                    </div>

                    <div class="form-left-3">
                        <div class="input-left">
                            <label for="wizard_person_adults"><?= tr ( '_GLOBAL_adults_' ); ?>:</label>
                            <input id="wizard_person_adults" name="person_adults" type="number" min="1" max="99" value="1" class="number required" tabindex="3">
                        </div>
                        <div class="input-rigth">
                            <label for="wizard_person_childrens"><?= tr ( '_GLOBAL_childrens_' ); ?>:</label>
                            <input id="wizard_person_childrens" name="person_childrens" type="number" min="0" max="99" value="0" class="number required" tabindex="4">
                        </div>
                        <div class="form-clear"></div>
                    </div>

                    <div class="form-clear"></div>

                    <div class="form-buttons-center">
                        <button id="wizard_step_one_check" class="button animated pulse"><?= tr ( '_PAGE_RESERVATION_WIZARD_check_price_and_availability_' ); ?></button>
                    </div>

                    <div class="alert success mt20 mb30 displayNone" id="wizard_step_one_success">
                        <?= tr ( '_PAGE_RESERVATION_WIZARD_check_price_and_availability_succes_' ); ?> <span id="wizard_price_stay" class="price_info">...</span>
                        <div class="col-clear"></div>
                    </div>

                    <div class="alert error mt20 displayNone" id="wizard_step_one_danger">
                        <?= tr ( '_PAGE_RESERVATION_WIZARD_check_price_and_availability_error_' ); ?>
                    </div>

                    <div class="form-buttons-rigth displayNone" id="wizard_step_one_buttons">
                        <div class="sep mt20"><span></span></div>
                        <button class="wizard_next" tabindex="5"><?= tr ( '_GLOBAL_next_' ); ?></button>
                    </div>

                </fieldset>

                <h3><?= tr ( '_PAGE_RESERVATION_WIZARD_step_two_title_' ); ?></h3>

                <fieldset>
                    <div class="sep mt20"><span></span></div>

                    <div class="alert notice"><?= tr ( '_PAGE_RESERVATION_WIZARD_step_two_help_' ); ?></div>

                    <div class="form-left mt20">

                        <label for="wizard_name"><?= tr ( '_GLOBAL_name_' ); ?>: </label>
                        <input id="wizard_name" name="name" type="text" class="required" tabindex="6">

                        <label for="wizard_phone"><?= tr ( '_GLOBAL_phone_' ); ?>: </label>
                        <input id="wizard_phone" name="phone" type="text" class="required" tabindex="8">

                        <label for="wizard_city"><?= tr ( '_GLOBAL_city_' ); ?>: </label>
                        <input id="wizard_city" name="city" type="text" class="required" tabindex="11">

                    </div>
                    <div class="form-rigth mt20">

                        <label for="wizard_lastname"><?= tr ( '_GLOBAL_lastname_' ); ?>: </label>
                        <input id="wizard_lastname" name="lastname" type="text" class="required" tabindex="7">

                        <label for="wizard_email"><?= tr ( '_GLOBAL_email_' ); ?>: </label>
                        <input id="wizard_email" name="email" type="email" class="required" tabindex="9">

                        <label for="wizard_email_repeat"><?= tr ( '_GLOBAL_email_repeat_' ); ?>: </label>
                        <input id="wizard_email_repeat" name="email_repeat" type="email" class="required" tabindex="10">

                    </div>

                    <div class="form-clear"></div>

                    <div class="form-full">
                        <label for="wizard_address"><?= tr ( '_GLOBAL_address_' ); ?>: </label>
                        <input id="wizard_address" name="address" type="text" class="required" tabindex="12">
                    </div>

                    <div class="form-left">

                        <label for="wizard_postcode"><?= tr ( '_GLOBAL_postcode_' ); ?>: </label>
                        <input id="wizard_postcode" name="postcode" type="text" class="required" tabindex="13">

                    </div>
                    <div class="form-rigth">

                        <label for="wizard_country"><?= tr ( '_GLOBAL_country_' ); ?>: </label>
                        <input id="wizard_country" name="country" type="text" class="required" tabindex="14">

                    </div>

                    <div class="form-clear"></div>

                    <div class="form-full">
                        <label for="wizard_comments"><?= tr ( '_GLOBAL_comments_' ); ?>: </label>
                        <textarea id="wizard_comments" name="comments" tabindex="15"></textarea>
                    </div>

                    <div class="form-clear"></div>

                    <div class="form-buttons-rigth" id="wizard_step_two_buttons">
                        <div class="sep mt20"><span></span></div>
                        <button class="wizard_back" tabindex="17"><?= tr ( '_GLOBAL_back_' ); ?></button>
                        <button class="wizard_next" tabindex="16"><?= tr ( '_GLOBAL_next_' ); ?></button>
                    </div>

                </fieldset>

                <h3><?= tr ( '_PAGE_RESERVATION_WIZARD_step_three_title_' ); ?></h3>

                <fieldset>

                    <div class="sep mt20"><span></span></div>

                    <?php if ( isset ( $data['complements'] ) && is_array ( $data['complements'] ) && !empty ( $data['complements'] ) ) : ?>

                        <div class="alert notice mb20 "><?= tr ( '_PAGE_RESERVATION_WIZARD_step_three_help_' ); ?></div>

                        <div class="complements">
                            <?php foreach ( $data['complements'] as $complement ) : ?>
                                <div class="complement">
                                    <div class="complement-info">
                                        <h4><?= $complement['titulo']; ?> - <?= $complement['precio']; ?></h4>
                                        <p><?= $complement['texto']; ?></p>
                                    </div>
                                    <div class="complement-quanty">
                                        <input type="number" name="complements[<?= $complement['id']; ?>]" min="0" max="<?= $complement['maximo_unidades']; ?>" data-id="<?= $complement['id']; ?>" data-multiplicator="<?= $complement['metodo_calculo']; ?>" data-price="<?= $complement['precio']; ?>" value="0" class="number help" title="<?= tr ( '_GLOBAL_max_quantity_', $complement['maximo_unidades'] ); ?>"/>
                                        <div class="form-clear"></div>
                                        <span class="complement-price" id="complement-price-<?= $complement['id']; ?>">0.00 €</span>
                                    </div>
                                    <div class="form-clear"></div>
                                    <div class="alert success">
                                        <?= tr ( '_PAGE_RESERVATION_WIZARD_complements_info_' . $complement['metodo_calculo'] . '_' ); ?>
                                    </div>

                                </div>
                            <?php endforeach; ?>
                        </div>

                    <?php else : ?>

                        <div class="alert error"><?= tr ( '_PAGE_RESERVATION_WIZARD_step_three_help_error_' ); ?></div>

                    <?php endif; ?>

                    <div class="form-clear"></div>

                    <div class="form-buttons-rigth" id="wizard_step_three_buttons">
                        <div class="sep mt20"><span></span></div>
                        <button class="wizard_back"><?= tr ( '_GLOBAL_back_' ); ?></button>
                        <button class="wizard_next"><?= tr ( '_GLOBAL_next_' ); ?></button>
                    </div>

                </fieldset>

                <h3><?= tr ( '_PAGE_RESERVATION_WIZARD_step_final_title_' ); ?></h3>

                <fieldset>

                    <div class="sep mt20"><span></span></div>

                    <div id="final_step_messages" class="displayNone">

                    </div>

                    <div id="final_step_validator">

                        <div class="alert info">
                            <h3 class="mb0"><?= tr ( '_PAGE_RESERVATION_WIZARD_step_final_help_' ); ?></h3>
                        </div>

                        <ul class="totals">
                            <li>&raquo; <?= tr ( '_GLOBAL_price_stay_' ); ?><span id="wizard_total_price_stay"></span></li>
                            <li>&raquo; <?= tr ( '_GLOBAL_price_complements_' ); ?><span id="wizard_total_price_complements"></span></li>
                            <li class="separator"></li>
                            <li><?= tr ( '_GLOBAL_price_subtotal_' ); ?><span id="wizard_total_price_subtotal"></span></li>
                            <li class="separator"></li>
                            <li><?= tr ( '_GLOBAL_price_recharge_' ); ?><span id="wizard_total_price_recharge"></span></li>
                            <li class="separator"></li>
                            <li class="total"><?= tr ( '_GLOBAL_price_total_' ); ?><span id="wizard_total_price_total"></span></li>
                            <li class="separator"></li>
                            <li class="deposit"><?= tr ( '_GLOBAL_price_deposit_' ); ?><span id="wizard_total_price_deposit"></span></li>
                        </ul>

                        <div class="alert info mt20 mb20">
                            <h3 class="mb0"><?= tr ( '_PAGE_RESERVATION_WIZARD_step_final_payments_select_' ); ?></h3>
                        </div>

                        <select class="image-picker required" name="payments_methods" id="wizard_payments_methods">
                            <option value="0"></option>
                            <?php foreach ( $data['payments_methods'] as $payments_methods ) : ?>
                                <option
                                    data-price-recharge="<?= $payments_methods['porcentaje_recargo']; ?>"
                                    data-price-deposit="<?= $payments_methods['porcentaje_pago']; ?>"
                                    data-img-label="<?= $payments_methods['texto']; ?>"
                                    data-img-src="<?= $this->template->path ( 'img', $payments_methods['image'] . '.jpg' ); ?>"
                                    value="<?= $payments_methods['uID']; ?>"
                                    ><?= $payments_methods['texto']; ?></option>
                                <?php endforeach; ?>
                        </select>

                        <?php foreach ( $data['payments_methods'] as $payments_methods ) : ?>

                            <div id="wizard_payments_method_help_<?= $payments_methods['uID']; ?>" class="payments_methods_help displayNone">

                                <div class="alert notice mt20"><?= tr ( '_PAGE_RESERVATION_WIZARD_PAYMENTS_HELP' . $payments_methods['image'] ); ?></div>

                            </div>

                        <?php endforeach; ?>

                        <div class="alert error mt10 displayNone payments_methods_help_error"><?= tr ( '_PAGE_RESERVATION_WIZARD_PAYMENTS_error_' ); ?></div>


                        <div class="alert info mt20 mb20">
                            <h3 class="mb0"><?= tr ( '_PAGE_RESERVATION_WIZARD_step_final_conditions_' ); ?></h3>
                        </div>

                        <input type="checkbox" name="conditions" id="wizard_conditions" value="" class="required" style="float:left;">
                        <label for="wizard_conditions" style="float:left; margin-left: 5px;">
                            <a href="<?= frontend_url ( array ( 'reservation', 'conditions' ) ); ?>" target="_blank"><?= tr ( '_GLOBAL_conditions_' ); ?></a>
                        </label>
                        <div class="form-clear"></div>

                        <div class="alert error mt10 displayNone payments_methods_conditions_error"><?= tr ( '_PAGE_RESERVATION_WIZARD_CONDITIONS_error_' ); ?></div>

                        <div class="form-clear"></div>

                        <div class="form-buttons-rigth" id="wizard_step_three_buttons">
                            <div class="sep mt20"><span></span></div>
                            <button class="wizard_back"><?= tr ( '_GLOBAL_back_' ); ?></button>
                            <button class="wizard_final"><?= tr ( '_GLOBAL_book_now_' ); ?></button>
                        </div>

                    </div>

                </fieldset>

            </form>

        </div>

        <div class="col-rigth">
            <h2><?= tr ( '_PAGE_RESERVATION_CALENDAR_title_' ); ?></h2>
            <div>
                <ul class="legend_calendar">
                    <li class="available"><span></span> <?= tr ( '_GLOBAL_available_' ); ?></li>
                    <li class="hot_deal"><span></span> <?= tr ( '_GLOBAL_hot_deal_' ); ?></li>
                    <li class="pre_reserved"><span></span> <?= tr ( '_GLOBAL_pre_reserved_' ); ?></li>
                    <li class="booked"><span></span> <?= tr ( '_GLOBAL_booked_' ); ?></li>
                </ul>
                <div class="col-clear"></div>
            </div>
            <div id="availability_calendar" class="mt10"></div>
        </div>

        <div class="col-clear"></div>
    </div>
    <footer id="footer-full-page" class="full-page">
        <div class="social-icons">
            <?php if ( !empty ( $this->settings_model->system['_social_facebook_'] ) ) : ?>
                <a href="<?= $this->settings_model->system['_social_facebook_']; ?>" class="facebook"></a>
            <?php endif; ?>
            <?php if ( !empty ( $this->settings_model->system['_social_twitter_'] ) ) : ?>
                <a href="<?= $this->settings_model->system['_social_twitter_']; ?>" class="twitter"></a>
            <?php endif; ?>
            <?php if ( !empty ( $this->settings_model->system['_social_google_plus_'] ) ) : ?>
                <a href="<?= $this->settings_model->system['_social_google_plus_']; ?>" class="googleplus"></a>
            <?php endif; ?>
        </div>
        <div class="links">

            <span class="copyright"><?= $this->settings_model->system['_system_copyright_']; ?></span>

            <?php foreach ( get_languages () as $lang ) : ?>

                <a href="<?= switch_lang ( $lang['code'] ) ?>" class="language<?= ( $lang['code'] == current_language () ) ? ' active' : ''; ?>">
                    <span class="flag flag-<?= $lang['code'] ?>"></span>
                </a>
            <?php endforeach; ?>

        </div>
        <div class="clear"></div>
    </footer>
</section>
<?php $this->template->widget ( 'gallery', 'gallery_model', 'get_one', 1, 'image_no_zoom' ); ?>