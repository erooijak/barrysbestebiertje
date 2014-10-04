<?php

class McSubscribeWidget extends WP_Widget
{

    public function __construct()
    {
        parent::__construct(false, 'MailChimp Subscribe');
    }

    /**
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
        $title = $title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
        echo $args['before_widget'];

        if ($title) {
            echo $args['before_title'];
            echo $title;
            echo $args['after_title'];
        }
        ?>

        <?php if ($instance['text']) : ?>
            <p><?php echo $instance['text'] ?></p>
        <?php endif ?>

        <form class="mcsw_form"
              id="mcsw_form-<?php echo $this->id ?>">

            <div class="control">
                <input type="email" 
                       name="email"
                       placeholder="<?php echo $instance['email_placeholder'] ?>" />

                <p class="hidden message"></p>
            </div>

            <input type="submit" 
                   value="<?php echo $instance['button_text'] ?>"
                   class="submit" />

            <div class="loader hidden"></div>

            <input type="hidden" name="widget_id" value="<?php echo $this->id ?>" />
            
            <?php wp_nonce_field(mcsw_nonce_action()) ?>
        </form>

        <?php
        echo $args['after_widget'];
    }

    /**
     * Outputs the options form on admin
     * @param array $instance The widget options
     */
    public function form($instance)
    {
        $instance = wp_parse_args($instance, $this->get_defaults());
        $lists = $this->get_lists($instance['api_key']);
        $this->output_text_field('api_key', 'API Key', $instance['api_key']);
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('list_id') ?>">Mailing List</label>

            <select class="widefat" 
                    id="<?php echo $this->get_field_id('list_id') ?>" 
                    name="<?php echo $this->get_field_name('list_id') ?>">

                <?php foreach ($lists as $list_id => $list_name) : ?>

                    <option value="<?php echo $list_id ?>" <?php echo $instance['list_id'] == $list_id ? 'selected="true"' : '' ?>>
                        <?php echo $list_name ?>
                    </option>

                <?php endforeach ?>
            </select>
        </p>

        <?php
        $this->output_text_field('title', 'Title', $instance['title']);
        $this->output_text_field('text', 'Text', $instance['text']);
        $this->output_text_field('email_placeholder', 'Email Placeholder', $instance['email_placeholder']);
        $this->output_text_field('button_text', 'Button Text', $instance['button_text']);
        $this->output_text_field('success_message', 'Success Message', $instance['success_message']);
        $this->output_text_field('error_message', 'Error Message', $instance['error_message']);
    }

    public function output_text_field($setting_name, $setting_label, $setting_value)
    {
        ?>

        <p>
            <label for="<?php echo $this->get_field_id($setting_name) ?>">
                <?php echo $setting_label ?>
            </label>

            <input class="widefat" 
                   id="<?php echo $this->get_field_id($setting_name) ?>" 
                   name="<?php echo $this->get_field_name($setting_name) ?>" 
                   type="text" 
                   value="<?php echo $setting_value ?>" />
        </p>

        <?php
    }

    /**
     * Default widget settings
     * @return array
     */
    public function get_defaults()
    {
        return array(
            'api_key' => '',
            'list_id' => '',
            'title' => 'Subscribe to our newsletter',
            'text' => '',
            'email_placeholder' => 'Email',
            'button_text' => 'Subscribe',
            'success_message' => 'Thanks!',
            'error_message' => 'Oops, something went wrong!'
        );
    }

    /**
     * Returns available lists from MailChimp as an associative array: 
     * [list id] => [list name]
     * 
     * @param string $api_key
     * @return array Associative array of the following structure: [list id] => [list name]
     */
    public function get_lists($api_key)
    {
        $ret = array('' => 'Select a mailing list');

        try {
            $mc_lists = new Mailchimp_Lists(new Mailchimp($api_key));
            $result = $mc_lists->getList();

            foreach ($result['data'] as $list) {
                $ret[$list['id']] = $list['name'];
            }
        } catch (Exception $ex) {
            $ret = array(
                '' => 'No lists found'
            );
        }

        return $ret;
    }

}
