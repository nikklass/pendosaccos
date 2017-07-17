import Vue from 'vue';

export default {

    bind: function (el, binding, vnode) {
        el.addEventListener(
            'submit', function(e){

                e.preventDefault();

                let button = el.querySelector('button[type="submit"]');
                //let buttonText = button.val;
                //let loadingText = button.data('loading-text') || 'Submitting...';
                button.disabled = true;
                let resetForm = true
                let formData = new FormData(el);

                //button.val(loadingText);

                let formInstance = el
                let method = el.method.toLowerCase();
                Vue.http[method](el.action, formData)
                    .then(function(response){

                        if(!response.body.error && resetForm)
                        {

                            console.log(response.body.post);

                            response.body = response;

                            // Remove highlights
                            //removeErrorHighlight();

                            // Reset the form
                            formInstance.reset();

                            // check success handler is present
                            /*if (vnode.data.on && vnode.data.on.success) {
                                vnode.data.on.success.fn.call(this, response);
                            } else {
                                // run default handler
                                //responseSuccessHandler(response);
                            }*/

                            // show success message here, I prefer noty
                        }

                        //button.disabled = false;
                    })
                    .catch( (err) => {

                        console.log('err - ' + err);

                        // Adding a body property to keep the same api
                        err.body = err.responseJSON;

                        // check error handler is present
                        if (vnode.data.on && vnode.data.on.error) {
                            vnode.data.on.error.fn.call(this, err);
                        } else {
                            // run default handler
                            responseErrorHandler(err);
                        }

                    });

                // Re-enable button with old value
                //button.val(buttonText);
                button.disabled = false;

            }
        );
    }

}


// Default error response handler
function responseErrorHandler(response) {
    // handle authorization error
    if( response.status === 401 ) {
        swal({
            title: response.statusText,
            text: response.body.msg,
            timer: 1500
        }, function(){
            window.location.reload();
        });
    }

    // any other error
    if( response.status >= 400 ) {
        if( response.status === 422 ) {
            // validation error
            swal("Validation Error!", getValidationError(response.body), 'error');
        } else {
            // handle other errors
            var msg = response.body.msg || 'Unable to process your request.';
            swal(response.statusText, msg, 'error');
        }
    }
}


/*
export default {

    bind: function (el, binding, vnode) {
        el.addEventListener(
            'submit', function(e){

                e.preventDefault();

                let button = el.querySelector('button[type="submit"]');
                button.disabled = true;
                let resetForm = true
                let formData = new FormData(el)

                let formInstance = el
                let method = el.method.toLowerCase();
                Vue.http[method](el.action, formData)
                    .then(function(response){

                        if(!response.data.error && resetForm)
                        {
                            formInstance.reset();

                            // show success message here, I prefer noty
                        }

                        button.disabled = false;
                    })
            }
        );
    }

}
*/


/*


export default {

    bind: function (el, binding, vnode) {
        // form element
        var $el = $(el),
            // Submit input button
            submitBtn = $el.closest('form').find(':submit'),
            // Submit input value
            submitBtnText = submitBtn.val(),
            // Loading text, use data-loading-text if found
            loadingText = submitBtn.data('loading-text') || 'Submitting...',
            // Form Method
            method = $el.find('input[name=_method]').val() || $el.prop('method'),
            // Action url for form
            url = $el.prop('action');

        // On form submit handler
        $el.on('submit', function (e) {
            // Prevent default action
            e.preventDefault();

            // Serialize the form data
            var formData = $el.serialize();

            // Disable the button and change the loading text
            submitBtn.val(loadingText);
            submitBtn.prop('disabled', true);

            method = method.toLowerCase();

            Vue.http[method](el.action, formData)
                .then(function(response){

                    if(!response.data.error && resetForm)
                    {
                        // Adding a body property to keep the same api
                        res.body = response.post;

                        // Remove highlights
                        removeErrorHighlight();

                        // Reset the form
                        $el[0].reset();

                        // check success handler is present
                        if (vnode.data.on && vnode.data.on.success) {
                            vnode.data.on.success.fn.call(this, response);
                        } else {
                            // run default handler
                            responseSuccessHandler(response);
                        }

                        // show success message here, I prefer noty
                    }

                    button.disabled = false;
                })
                .catch( (err) => {

                    // Adding a body property to keep the same api
                    err.body = err.responseJSON;

                    // check error handler is present
                    if (vnode.data.on && vnode.data.on.error) {
                        vnode.data.on.error.fn.call(this, err);
                    } else {
                        // run default handler
                        responseErrorHandler(err);
                    }

                });

            // Re-enable button with old value
            submitBtn.val(submitBtnText);
            submitBtn.prop('disabled', false);



            // make http call using jQuery
            $.ajax({url: url, method: method, data: formData})
                .done(function (res) {
                    // Adding a body property to keep the same api
                    res.body = res;

                    // Remove highlights
                    removeErrorHighlight();

                    // Reset the form
                    $el[0].reset();

                    // check success handler is present
                    if (vnode.data.on && vnode.data.on.success) {
                        vnode.data.on.success.fn.call(this, res);
                    } else {
                        // run default handler
                        responseSuccessHandler(res);
                    }
                }).fail(function (err) {
                // Adding a body property to keep the same api
                err.body = err.responseJSON;

                // check error handler is present
                if (vnode.data.on && vnode.data.on.error) {
                    vnode.data.on.error.fn.call(this, err);
                } else {
                    // run default handler
                    responseErrorHandler(err);
                }
            }).always(function () {
                // Re-enable button with old value
                submitBtn.val(submitBtnText);
                submitBtn.prop('disabled', false);
            });



        });
    }

}

*/
