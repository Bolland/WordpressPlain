(function(){tinymce.create("tinymce.plugins.WooCommerceShortcodes",{init:function(e,t){},createControl:function(e,t){var n=tinymce.activeEditor;if(e=="woocommerce_shortcodes_button"){e=t.createMenuButton("woocommerce_shortcodes_button",{title:n.getLang("woocommerce.insert"),icons:!1});var r=this;e.onRenderMenu.add(function(e,t){r.addImmediate(t,n.getLang("woocommerce.order_tracking"),"[woocommerce_order_tracking]");r.addImmediate(t,n.getLang("woocommerce.price_button"),'[add_to_cart id="" sku=""]');r.addImmediate(t,n.getLang("woocommerce.product_by_sku"),'[product id="" sku=""]');r.addImmediate(t,n.getLang("woocommerce.products_by_sku"),'[products ids="" skus=""]');r.addImmediate(t,n.getLang("woocommerce.product_categories"),'[product_categories number=""]');r.addImmediate(t,n.getLang("woocommerce.products_by_cat_slug"),'[product_category category="" per_page="12" columns="4" orderby="date" order="desc"]');t.addSeparator();r.addImmediate(t,n.getLang("woocommerce.recent_products"),'[recent_products per_page="12" columns="4" orderby="date" order="desc"]');r.addImmediate(t,n.getLang("woocommerce.featured_products"),'[featured_products per_page="12" columns="4" orderby="date" order="desc"]');t.addSeparator();r.addImmediate(t,n.getLang("woocommerce.shop_messages"),"[woocommerce_messages]");t.addSeparator();e=t.addMenu({title:n.getLang("woocommerce.pages")});r.addImmediate(e,n.getLang("woocommerce.cart"),"[woocommerce_cart]");r.addImmediate(e,n.getLang("woocommerce.checkout"),"[woocommerce_checkout]");r.addImmediate(e,n.getLang("woocommerce.my_account"),"[woocommerce_my_account]");r.addImmediate(e,n.getLang("woocommerce.edit_address"),"[woocommerce_edit_address]");r.addImmediate(e,n.getLang("woocommerce.change_password"),"[woocommerce_change_password]");r.addImmediate(e,n.getLang("woocommerce.view_order"),"[woocommerce_view_order]");r.addImmediate(e,n.getLang("woocommerce.pay"),"[woocommerce_pay]");r.addImmediate(e,n.getLang("woocommerce.thankyou"),"[woocommerce_thankyou]")});return e}return null},addImmediate:function(e,t,n){e.add({title:t,onclick:function(){tinyMCE.activeEditor.execCommand("mceInsertContent",!1,n)}})}});tinymce.PluginManager.add("WooCommerceShortcodes",tinymce.plugins.WooCommerceShortcodes)})();