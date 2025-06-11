const Field = {
    // BUTTON
    BtnGet   : $('.FieldBtnGet'),
    BtnGetAll: $('.FieldBtnGetAll'),
    BtnCreate: $('.FieldBtnCreate'),
    BtnUpdate: $('.FieldBtnUpdate'),
    BtnDelete: $('.FieldBtnDelete'),

    // FORM
    FrmGet   : $('.FieldFrmGet'),
    FrmGetAll: $('.FieldFrmGetAll'),
    FrmCreate: $('.FieldFrmCreate'),
    FrmUpdate: $('.FieldFrmUpdate'),
    FrmDelete: $('.FieldFrmDelete'),

    // MODAL
    MdlGet   : $('.FieldMdlGet'),
    MdlGetAll: $('.FieldMdlGetAll'),
    MdlCreate: $('.FieldMdlCreate'),
    MdlUpdate: $('.FieldMdlUpdate'),
    MdlDelete: $('.FieldMdlDelete'),

    // MODAL BUTTON
    BtnMdlGet   : $('.FieldBtnMdlGet'),
    BtnMdlGetAll: $('.FieldBtnMdlGetAll'),
    BtnMdlCreate: $('.FieldBtnMdlCreate'),
    BtnMdlUpdate: $('.FieldBtnMdlUpdate'),
    BtnMdlDelete: $('.FieldBtnMdlDelete'),

    // AJAX
    req({type, url, data = {}, ok, err}) {
        $.ajax({
            type,
            url,
            data,
            success: res => ok ? ok(res) : console.log(res.message),
            error  : res => err ? err(res) : console.log(res.responseJSON?.message || res.statusText)
        });
    },

    // API METHODS
    Get:    ({id, ok, err})        => Field.req({type: 'GET',    url: `api/field/${id}`, ok, err}),
    GetAll: ({q = {}, ok, err}={}) => {
        const url = Object.keys(q).length ? `api/field?${$.param(q)}` : 'api/field';
        Field.req({type: 'GET', url, ok, err});
    },
    Create: ({data, ok, err})      => Field.req({type: 'POST',   url: 'api/field', data, ok, err}),
    Update: ({id, data, ok, err})  => Field.req({type: 'PUT',    url: `api/field/${id}`, data, ok, err}),
    Delete: ({id, ok, err})        => Field.req({type: 'DELETE', url: `api/field/${id}`, ok, err}),

    // UPLOAD FILE
    uploadFile({ input, ok, err }) {
        const $input = (input instanceof jQuery) ? input : $(input);
        const fileInput = $input[0];
        if (!$input.length || !fileInput.files.length) return;

        const type = $input.data('type');
        const url = $input.data('upload-url');

        if (!type || !url) {
            console.warn('❌ data-type veya data-upload-url eksik');
            return;
        }

        const isMultiple = EnumUploadMultiple[type] === true;
        const fieldName = fileInput.name || type;

        const formData = new FormData();

        // Çoklu veya tekli dosya ekle
        if (isMultiple) {
            for (let i = 0; i < fileInput.files.length; i++) {
                formData.append(fieldName + '[]', fileInput.files[i]);
            }
        } else {
            formData.append(fieldName, fileInput.files[0]);
        }

        // data-extra-* attributeları topla
        $.each($input.data(), (key, value) => {
            if (key.startsWith('extra')) {
                const cleanKey = key.replace(/^extra/, '').replace(/^[A-Z]/, c => c.toLowerCase());
                formData.append(cleanKey, value);
            }
        });

        $.ajax({
            type: 'POST',
            url,
            data: formData,
            contentType: false,
            processData: false,
            success: res => ok ? ok(res) : console.log(res.message),
            error: res => err ? err(res) : console.log(res.responseJSON?.message || res.statusText)
        });
    },

    // FORM BINDINGS
    bindFormCreate({ button, form = null, apiMethod = null, redirectUrl = null, onSuccess = null, onBefore = null }) {
        button.off('click').click(() => {
            if (typeof onBefore === 'function') onBefore();
            const $btn = $(button);

            let formSelector = form || $btn.data('form');
            if (typeof formSelector === 'string' && !formSelector.startsWith('.') && !formSelector.startsWith('#')) {
                formSelector = '.' + formSelector;
            }
            const finalForm = (formSelector instanceof jQuery) ? formSelector : $(formSelector);

            const finalApiMethod = apiMethod || Field[$btn.data('api')];
            const finalRedirect = redirectUrl || $btn.data('redirect');

            const data = xsh.getFormData(finalForm);

            finalApiMethod({
                data,
                ok: (res) => {
                    xsh.showNotification({
                        message: res.message,
                        callback: () => {
                            if (onSuccess) onSuccess(res);
                            else if (finalRedirect) xsh.redirectTo(finalRedirect);
                        }
                    });
                }
            });
        });
    },

    bindFormUpdate({ button, form = null, apiMethod = null, redirectUrl = null, onSuccess = null, onBefore = null }) {
        button.off('click').click(() => {
            if (typeof onBefore === 'function') onBefore();
            const $btn = $(button);

            let formSelector = form || $btn.data('form');
            if (typeof formSelector === 'string' && !formSelector.startsWith('.') && !formSelector.startsWith('#')) {
                formSelector = '.' + formSelector;
            }
            const finalForm = (formSelector instanceof jQuery) ? formSelector : $(formSelector);

            const finalApiMethod = apiMethod || Field[$btn.data('api')];
            const finalRedirect = redirectUrl || $btn.data('redirect');
            const finalId = $btn.data('id');

            const data = xsh.getFormData(finalForm);

            finalApiMethod({
                id: finalId,
                data,
                ok: (res) => {
                    xsh.showNotification({
                        message: res.message,
                        callback: () => {
                            if (onSuccess) onSuccess(res);
                            else if (finalRedirect) xsh.redirectTo(finalRedirect);
                        }
                    });
                }
            });
        });
    },

    bindFormDelete({ button, apiMethod = null, redirectUrl = null, onSuccess = null, onBefore = null }) {
        button.off('click').click(() => {
            if (typeof onBefore === 'function') onBefore();
            const $btn = $(button);
            const finalApiMethod = apiMethod || Field[$btn.data('api')];
            const finalRedirect = $btn.data('redirect');
            const finalId = $btn.data('id');

            finalApiMethod({
                id: finalId,
                ok: (res) => {
                    xsh.showNotification({
                        message: res.message,
                        callback: () => {
                            if (onSuccess) onSuccess(res);
                            else if (finalRedirect) xsh.redirectTo(finalRedirect);
                        }
                    });
                }
            });
        });
    },

    // AUTO BIND
    autoBindFormActions() {
        const map = {
            '.FieldBtnCreate': Field.bindFormCreate,
            '.FieldBtnUpdate': Field.bindFormUpdate,
            '.FieldBtnDelete': Field.bindFormDelete,
        };

        Object.entries(map).forEach(([selector, handler]) => {
            $(selector).each((i, btn) => {
                const $btn = $(btn);
                const formSelector = $btn.data('form');
                const redirectUrl = $btn.data('redirect');
                const apiMethodName = $btn.data('api');

                if (!apiMethodName || typeof this[apiMethodName] !== 'function') return;

                const options = {
                    button: $btn,
                    form: formSelector,
                    apiMethod: this[apiMethodName],
                    redirectUrl
                };

                handler.call(this, options);
            });
        });
    }
};

// AUTO BIND
Field.autoBindFormActions();
const Location = {
    // BUTTON
    BtnGet   : $('.LocationBtnGet'),
    BtnGetAll: $('.LocationBtnGetAll'),
    BtnCreate: $('.LocationBtnCreate'),
    BtnUpdate: $('.LocationBtnUpdate'),
    BtnDelete: $('.LocationBtnDelete'),

    // FORM
    FrmGet   : $('.LocationFrmGet'),
    FrmGetAll: $('.LocationFrmGetAll'),
    FrmCreate: $('.LocationFrmCreate'),
    FrmUpdate: $('.LocationFrmUpdate'),
    FrmDelete: $('.LocationFrmDelete'),

    // MODAL
    MdlGet   : $('.LocationMdlGet'),
    MdlGetAll: $('.LocationMdlGetAll'),
    MdlCreate: $('.LocationMdlCreate'),
    MdlUpdate: $('.LocationMdlUpdate'),
    MdlDelete: $('.LocationMdlDelete'),

    // MODAL BUTTON
    BtnMdlGet   : $('.LocationBtnMdlGet'),
    BtnMdlGetAll: $('.LocationBtnMdlGetAll'),
    BtnMdlCreate: $('.LocationBtnMdlCreate'),
    BtnMdlUpdate: $('.LocationBtnMdlUpdate'),
    BtnMdlDelete: $('.LocationBtnMdlDelete'),

    // AJAX
    req({type, url, data = {}, ok, err}) {
        $.ajax({
            type,
            url,
            data,
            success: res => ok ? ok(res) : console.log(res.message),
            error  : res => err ? err(res) : console.log(res.responseJSON?.message || res.statusText)
        });
    },

    // API METHODS
    Get:    ({id, ok, err})        => Location.req({type: 'GET',    url: `api/location/${id}`, ok, err}),
    GetAll: ({q = {}, ok, err}={}) => {
        const url = Object.keys(q).length ? `api/location?${$.param(q)}` : 'api/location';
        Location.req({type: 'GET', url, ok, err});
    },
    Create: ({data, ok, err})      => Location.req({type: 'POST',   url: 'api/location', data, ok, err}),
    Update: ({id, data, ok, err})  => Location.req({type: 'PUT',    url: `api/location/${id}`, data, ok, err}),
    Delete: ({id, ok, err})        => Location.req({type: 'DELETE', url: `api/location/${id}`, ok, err}),

    // UPLOAD FILE
    uploadFile({ input, ok, err }) {
        const $input = (input instanceof jQuery) ? input : $(input);
        const fileInput = $input[0];
        if (!$input.length || !fileInput.files.length) return;

        const type = $input.data('type');
        const url = $input.data('upload-url');

        if (!type || !url) {
            console.warn('❌ data-type veya data-upload-url eksik');
            return;
        }

        const isMultiple = EnumUploadMultiple[type] === true;
        const fieldName = fileInput.name || type;

        const formData = new FormData();

        // Çoklu veya tekli dosya ekle
        if (isMultiple) {
            for (let i = 0; i < fileInput.files.length; i++) {
                formData.append(fieldName + '[]', fileInput.files[i]);
            }
        } else {
            formData.append(fieldName, fileInput.files[0]);
        }

        // data-extra-* attributeları topla
        $.each($input.data(), (key, value) => {
            if (key.startsWith('extra')) {
                const cleanKey = key.replace(/^extra/, '').replace(/^[A-Z]/, c => c.toLowerCase());
                formData.append(cleanKey, value);
            }
        });

        $.ajax({
            type: 'POST',
            url,
            data: formData,
            contentType: false,
            processData: false,
            success: res => ok ? ok(res) : console.log(res.message),
            error: res => err ? err(res) : console.log(res.responseJSON?.message || res.statusText)
        });
    },

    // FORM BINDINGS
    bindFormCreate({ button, form = null, apiMethod = null, redirectUrl = null, onSuccess = null, onBefore = null }) {
        button.off('click').click(() => {
            if (typeof onBefore === 'function') onBefore();
            const $btn = $(button);

            let formSelector = form || $btn.data('form');
            if (typeof formSelector === 'string' && !formSelector.startsWith('.') && !formSelector.startsWith('#')) {
                formSelector = '.' + formSelector;
            }
            const finalForm = (formSelector instanceof jQuery) ? formSelector : $(formSelector);

            const finalApiMethod = apiMethod || Location[$btn.data('api')];
            const finalRedirect = redirectUrl || $btn.data('redirect');

            const data = xsh.getFormData(finalForm);

            finalApiMethod({
                data,
                ok: (res) => {
                    xsh.showNotification({
                        message: res.message,
                        callback: () => {
                            if (onSuccess) onSuccess(res);
                            else if (finalRedirect) xsh.redirectTo(finalRedirect);
                        }
                    });
                }
            });
        });
    },

    bindFormUpdate({ button, form = null, apiMethod = null, redirectUrl = null, onSuccess = null, onBefore = null }) {
        button.off('click').click(() => {
            if (typeof onBefore === 'function') onBefore();
            const $btn = $(button);

            let formSelector = form || $btn.data('form');
            if (typeof formSelector === 'string' && !formSelector.startsWith('.') && !formSelector.startsWith('#')) {
                formSelector = '.' + formSelector;
            }
            const finalForm = (formSelector instanceof jQuery) ? formSelector : $(formSelector);

            const finalApiMethod = apiMethod || Location[$btn.data('api')];
            const finalRedirect = redirectUrl || $btn.data('redirect');
            const finalId = $btn.data('id');

            const data = xsh.getFormData(finalForm);

            finalApiMethod({
                id: finalId,
                data,
                ok: (res) => {
                    xsh.showNotification({
                        message: res.message,
                        callback: () => {
                            if (onSuccess) onSuccess(res);
                            else if (finalRedirect) xsh.redirectTo(finalRedirect);
                        }
                    });
                }
            });
        });
    },

    bindFormDelete({ button, apiMethod = null, redirectUrl = null, onSuccess = null, onBefore = null }) {
        button.off('click').click(() => {
            if (typeof onBefore === 'function') onBefore();
            const $btn = $(button);
            const finalApiMethod = apiMethod || Location[$btn.data('api')];
            const finalRedirect = $btn.data('redirect');
            const finalId = $btn.data('id');

            finalApiMethod({
                id: finalId,
                ok: (res) => {
                    xsh.showNotification({
                        message: res.message,
                        callback: () => {
                            if (onSuccess) onSuccess(res);
                            else if (finalRedirect) xsh.redirectTo(finalRedirect);
                        }
                    });
                }
            });
        });
    },

    // AUTO BIND
    autoBindFormActions() {
        const map = {
            '.LocationBtnCreate': Location.bindFormCreate,
            '.LocationBtnUpdate': Location.bindFormUpdate,
            '.LocationBtnDelete': Location.bindFormDelete,
        };

        Object.entries(map).forEach(([selector, handler]) => {
            $(selector).each((i, btn) => {
                const $btn = $(btn);
                const formSelector = $btn.data('form');
                const redirectUrl = $btn.data('redirect');
                const apiMethodName = $btn.data('api');

                if (!apiMethodName || typeof this[apiMethodName] !== 'function') return;

                const options = {
                    button: $btn,
                    form: formSelector,
                    apiMethod: this[apiMethodName],
                    redirectUrl
                };

                handler.call(this, options);
            });
        });
    }
};

// AUTO BIND
Location.autoBindFormActions();
const Migration = {
    // BUTTON
    BtnGet   : $('.MigrationBtnGet'),
    BtnGetAll: $('.MigrationBtnGetAll'),
    BtnCreate: $('.MigrationBtnCreate'),
    BtnUpdate: $('.MigrationBtnUpdate'),
    BtnDelete: $('.MigrationBtnDelete'),

    // FORM
    FrmGet   : $('.MigrationFrmGet'),
    FrmGetAll: $('.MigrationFrmGetAll'),
    FrmCreate: $('.MigrationFrmCreate'),
    FrmUpdate: $('.MigrationFrmUpdate'),
    FrmDelete: $('.MigrationFrmDelete'),

    // MODAL
    MdlGet   : $('.MigrationMdlGet'),
    MdlGetAll: $('.MigrationMdlGetAll'),
    MdlCreate: $('.MigrationMdlCreate'),
    MdlUpdate: $('.MigrationMdlUpdate'),
    MdlDelete: $('.MigrationMdlDelete'),

    // MODAL BUTTON
    BtnMdlGet   : $('.MigrationBtnMdlGet'),
    BtnMdlGetAll: $('.MigrationBtnMdlGetAll'),
    BtnMdlCreate: $('.MigrationBtnMdlCreate'),
    BtnMdlUpdate: $('.MigrationBtnMdlUpdate'),
    BtnMdlDelete: $('.MigrationBtnMdlDelete'),

    // AJAX
    req({type, url, data = {}, ok, err}) {
        $.ajax({
            type,
            url,
            data,
            success: res => ok ? ok(res) : console.log(res.message),
            error  : res => err ? err(res) : console.log(res.responseJSON?.message || res.statusText)
        });
    },

    // API METHODS
    Get:    ({id, ok, err})        => Migration.req({type: 'GET',    url: `api/migration/${id}`, ok, err}),
    GetAll: ({q = {}, ok, err}={}) => {
        const url = Object.keys(q).length ? `api/migration?${$.param(q)}` : 'api/migration';
        Migration.req({type: 'GET', url, ok, err});
    },
    Create: ({data, ok, err})      => Migration.req({type: 'POST',   url: 'api/migration', data, ok, err}),
    Update: ({id, data, ok, err})  => Migration.req({type: 'PUT',    url: `api/migration/${id}`, data, ok, err}),
    Delete: ({id, ok, err})        => Migration.req({type: 'DELETE', url: `api/migration/${id}`, ok, err}),

    // UPLOAD FILE
    uploadFile({ input, ok, err }) {
        const $input = (input instanceof jQuery) ? input : $(input);
        const fileInput = $input[0];
        if (!$input.length || !fileInput.files.length) return;

        const type = $input.data('type');
        const url = $input.data('upload-url');

        if (!type || !url) {
            console.warn('❌ data-type veya data-upload-url eksik');
            return;
        }

        const isMultiple = EnumUploadMultiple[type] === true;
        const fieldName = fileInput.name || type;

        const formData = new FormData();

        // Çoklu veya tekli dosya ekle
        if (isMultiple) {
            for (let i = 0; i < fileInput.files.length; i++) {
                formData.append(fieldName + '[]', fileInput.files[i]);
            }
        } else {
            formData.append(fieldName, fileInput.files[0]);
        }

        // data-extra-* attributeları topla
        $.each($input.data(), (key, value) => {
            if (key.startsWith('extra')) {
                const cleanKey = key.replace(/^extra/, '').replace(/^[A-Z]/, c => c.toLowerCase());
                formData.append(cleanKey, value);
            }
        });

        $.ajax({
            type: 'POST',
            url,
            data: formData,
            contentType: false,
            processData: false,
            success: res => ok ? ok(res) : console.log(res.message),
            error: res => err ? err(res) : console.log(res.responseJSON?.message || res.statusText)
        });
    },

    // FORM BINDINGS
    bindFormCreate({ button, form = null, apiMethod = null, redirectUrl = null, onSuccess = null, onBefore = null }) {
        button.off('click').click(() => {
            if (typeof onBefore === 'function') onBefore();
            const $btn = $(button);

            let formSelector = form || $btn.data('form');
            if (typeof formSelector === 'string' && !formSelector.startsWith('.') && !formSelector.startsWith('#')) {
                formSelector = '.' + formSelector;
            }
            const finalForm = (formSelector instanceof jQuery) ? formSelector : $(formSelector);

            const finalApiMethod = apiMethod || Migration[$btn.data('api')];
            const finalRedirect = redirectUrl || $btn.data('redirect');

            const data = xsh.getFormData(finalForm);

            finalApiMethod({
                data,
                ok: (res) => {
                    xsh.showNotification({
                        message: res.message,
                        callback: () => {
                            if (onSuccess) onSuccess(res);
                            else if (finalRedirect) xsh.redirectTo(finalRedirect);
                        }
                    });
                }
            });
        });
    },

    bindFormUpdate({ button, form = null, apiMethod = null, redirectUrl = null, onSuccess = null, onBefore = null }) {
        button.off('click').click(() => {
            if (typeof onBefore === 'function') onBefore();
            const $btn = $(button);

            let formSelector = form || $btn.data('form');
            if (typeof formSelector === 'string' && !formSelector.startsWith('.') && !formSelector.startsWith('#')) {
                formSelector = '.' + formSelector;
            }
            const finalForm = (formSelector instanceof jQuery) ? formSelector : $(formSelector);

            const finalApiMethod = apiMethod || Migration[$btn.data('api')];
            const finalRedirect = redirectUrl || $btn.data('redirect');
            const finalId = $btn.data('id');

            const data = xsh.getFormData(finalForm);

            finalApiMethod({
                id: finalId,
                data,
                ok: (res) => {
                    xsh.showNotification({
                        message: res.message,
                        callback: () => {
                            if (onSuccess) onSuccess(res);
                            else if (finalRedirect) xsh.redirectTo(finalRedirect);
                        }
                    });
                }
            });
        });
    },

    bindFormDelete({ button, apiMethod = null, redirectUrl = null, onSuccess = null, onBefore = null }) {
        button.off('click').click(() => {
            if (typeof onBefore === 'function') onBefore();
            const $btn = $(button);
            const finalApiMethod = apiMethod || Migration[$btn.data('api')];
            const finalRedirect = $btn.data('redirect');
            const finalId = $btn.data('id');

            finalApiMethod({
                id: finalId,
                ok: (res) => {
                    xsh.showNotification({
                        message: res.message,
                        callback: () => {
                            if (onSuccess) onSuccess(res);
                            else if (finalRedirect) xsh.redirectTo(finalRedirect);
                        }
                    });
                }
            });
        });
    },

    // AUTO BIND
    autoBindFormActions() {
        const map = {
            '.MigrationBtnCreate': Migration.bindFormCreate,
            '.MigrationBtnUpdate': Migration.bindFormUpdate,
            '.MigrationBtnDelete': Migration.bindFormDelete,
        };

        Object.entries(map).forEach(([selector, handler]) => {
            $(selector).each((i, btn) => {
                const $btn = $(btn);
                const formSelector = $btn.data('form');
                const redirectUrl = $btn.data('redirect');
                const apiMethodName = $btn.data('api');

                if (!apiMethodName || typeof this[apiMethodName] !== 'function') return;

                const options = {
                    button: $btn,
                    form: formSelector,
                    apiMethod: this[apiMethodName],
                    redirectUrl
                };

                handler.call(this, options);
            });
        });
    }
};

// AUTO BIND
Migration.autoBindFormActions();
const User = {
    // BUTTON
    BtnGet   : $('.UserBtnGet'),
    BtnGetAll: $('.UserBtnGetAll'),
    BtnCreate: $('.UserBtnCreate'),
    BtnUpdate: $('.UserBtnUpdate'),
    BtnDelete: $('.UserBtnDelete'),

    // FORM
    FrmGet   : $('.UserFrmGet'),
    FrmGetAll: $('.UserFrmGetAll'),
    FrmCreate: $('.UserFrmCreate'),
    FrmUpdate: $('.UserFrmUpdate'),
    FrmDelete: $('.UserFrmDelete'),

    // MODAL
    MdlGet   : $('.UserMdlGet'),
    MdlGetAll: $('.UserMdlGetAll'),
    MdlCreate: $('.UserMdlCreate'),
    MdlUpdate: $('.UserMdlUpdate'),
    MdlDelete: $('.UserMdlDelete'),

    // MODAL BUTTON
    BtnMdlGet   : $('.UserBtnMdlGet'),
    BtnMdlGetAll: $('.UserBtnMdlGetAll'),
    BtnMdlCreate: $('.UserBtnMdlCreate'),
    BtnMdlUpdate: $('.UserBtnMdlUpdate'),
    BtnMdlDelete: $('.UserBtnMdlDelete'),

    // AJAX
    req({type, url, data = {}, ok, err}) {
        $.ajax({
            type,
            url,
            data,
            success: res => ok ? ok(res) : console.log(res.message),
            error  : res => err ? err(res) : console.log(res.responseJSON?.message || res.statusText)
        });
    },

    // API METHODS
    Get:    ({id, ok, err})        => User.req({type: 'GET',    url: `api/user/${id}`, ok, err}),
    GetAll: ({q = {}, ok, err}={}) => {
        const url = Object.keys(q).length ? `api/user?${$.param(q)}` : 'api/user';
        User.req({type: 'GET', url, ok, err});
    },
    Create: ({data, ok, err})      => User.req({type: 'POST',   url: 'api/user', data, ok, err}),
    Update: ({id, data, ok, err})  => User.req({type: 'PUT',    url: `api/user/${id}`, data, ok, err}),
    Delete: ({id, ok, err})        => User.req({type: 'DELETE', url: `api/user/${id}`, ok, err}),

    // UPLOAD FILE
    uploadFile({ input, ok, err }) {
        const $input = (input instanceof jQuery) ? input : $(input);
        const fileInput = $input[0];
        if (!$input.length || !fileInput.files.length) return;

        const type = $input.data('type');
        const url = $input.data('upload-url');

        if (!type || !url) {
            console.warn('❌ data-type veya data-upload-url eksik');
            return;
        }

        const isMultiple = EnumUploadMultiple[type] === true;
        const fieldName = fileInput.name || type;

        const formData = new FormData();

        // Çoklu veya tekli dosya ekle
        if (isMultiple) {
            for (let i = 0; i < fileInput.files.length; i++) {
                formData.append(fieldName + '[]', fileInput.files[i]);
            }
        } else {
            formData.append(fieldName, fileInput.files[0]);
        }

        // data-extra-* attributeları topla
        $.each($input.data(), (key, value) => {
            if (key.startsWith('extra')) {
                const cleanKey = key.replace(/^extra/, '').replace(/^[A-Z]/, c => c.toLowerCase());
                formData.append(cleanKey, value);
            }
        });

        $.ajax({
            type: 'POST',
            url,
            data: formData,
            contentType: false,
            processData: false,
            success: res => ok ? ok(res) : console.log(res.message),
            error: res => err ? err(res) : console.log(res.responseJSON?.message || res.statusText)
        });
    },

    // FORM BINDINGS
    bindFormCreate({ button, form = null, apiMethod = null, redirectUrl = null, onSuccess = null, onBefore = null }) {
        button.off('click').click(() => {
            if (typeof onBefore === 'function') onBefore();
            const $btn = $(button);

            let formSelector = form || $btn.data('form');
            if (typeof formSelector === 'string' && !formSelector.startsWith('.') && !formSelector.startsWith('#')) {
                formSelector = '.' + formSelector;
            }
            const finalForm = (formSelector instanceof jQuery) ? formSelector : $(formSelector);

            const finalApiMethod = apiMethod || User[$btn.data('api')];
            const finalRedirect = redirectUrl || $btn.data('redirect');

            const data = xsh.getFormData(finalForm);

            finalApiMethod({
                data,
                ok: (res) => {
                    xsh.showNotification({
                        message: res.message,
                        callback: () => {
                            if (onSuccess) onSuccess(res);
                            else if (finalRedirect) xsh.redirectTo(finalRedirect);
                        }
                    });
                }
            });
        });
    },

    bindFormUpdate({ button, form = null, apiMethod = null, redirectUrl = null, onSuccess = null, onBefore = null }) {
        button.off('click').click(() => {
            if (typeof onBefore === 'function') onBefore();
            const $btn = $(button);

            let formSelector = form || $btn.data('form');
            if (typeof formSelector === 'string' && !formSelector.startsWith('.') && !formSelector.startsWith('#')) {
                formSelector = '.' + formSelector;
            }
            const finalForm = (formSelector instanceof jQuery) ? formSelector : $(formSelector);

            const finalApiMethod = apiMethod || User[$btn.data('api')];
            const finalRedirect = redirectUrl || $btn.data('redirect');
            const finalId = $btn.data('id');

            const data = xsh.getFormData(finalForm);

            finalApiMethod({
                id: finalId,
                data,
                ok: (res) => {
                    xsh.showNotification({
                        message: res.message,
                        callback: () => {
                            if (onSuccess) onSuccess(res);
                            else if (finalRedirect) xsh.redirectTo(finalRedirect);
                        }
                    });
                }
            });
        });
    },

    bindFormDelete({ button, apiMethod = null, redirectUrl = null, onSuccess = null, onBefore = null }) {
        button.off('click').click(() => {
            if (typeof onBefore === 'function') onBefore();
            const $btn = $(button);
            const finalApiMethod = apiMethod || User[$btn.data('api')];
            const finalRedirect = $btn.data('redirect');
            const finalId = $btn.data('id');

            finalApiMethod({
                id: finalId,
                ok: (res) => {
                    xsh.showNotification({
                        message: res.message,
                        callback: () => {
                            if (onSuccess) onSuccess(res);
                            else if (finalRedirect) xsh.redirectTo(finalRedirect);
                        }
                    });
                }
            });
        });
    },

    // AUTO BIND
    autoBindFormActions() {
        const map = {
            '.UserBtnCreate': User.bindFormCreate,
            '.UserBtnUpdate': User.bindFormUpdate,
            '.UserBtnDelete': User.bindFormDelete,
        };

        Object.entries(map).forEach(([selector, handler]) => {
            $(selector).each((i, btn) => {
                const $btn = $(btn);
                const formSelector = $btn.data('form');
                const redirectUrl = $btn.data('redirect');
                const apiMethodName = $btn.data('api');

                if (!apiMethodName || typeof this[apiMethodName] !== 'function') return;

                const options = {
                    button: $btn,
                    form: formSelector,
                    apiMethod: this[apiMethodName],
                    redirectUrl
                };

                handler.call(this, options);
            });
        });
    }
};

// AUTO BIND
User.autoBindFormActions();
const Authorize = {
    // BUTTON
    BtnLogin       : $('.BtnLogin'),
    BtnRegister    : $('.BtnRegister'),
    BtnLostPassword: $('.BtnLostPassword'),
    BtnLogout      : $('.BtnLogout'),
    // FORM
    FrmLogin       : $('.FrmLogin'),
    FrmRegister    : $('.FrmRegister'),
    FrmLostPassword: $('.FrmLostPassword'),
    FrmLogout      : $('.FrmLogout'),
    // MODAL
    MdlLogin       : $('.MdlLogin'),
    MdlRegister    : $('.MdlRegister'),
    MdlLostPassword: $('.MdlLostPassword'),
    MdlLogout      : $('.MdlLogout'),
    // MODAL BUTTON
    BtnMdlLogin       : $('.BtnMdlLogin'),
    BtnMdlRegister    : $('.BtnMdlRegister'),
    BtnMdlLostPassword: $('.BtnMdlLostPassword'),
    BtnMdlLogout      : $('.BtnMdlLogout'),
    // AJAX
    req({type, url, data = {}, ok, err}) {
        $.ajax({
                   type,
                   url,
                   data,
                   success: res => ok ? ok(res) : console.log(res.message),
                   error  : res => err ? err(res) : xsh.showNotification({message : res.responseJSON.message})
               });
    },
    Login({data, ok, err}) {
        this.req({type: 'POST', url: 'api/login', data, ok, err});
    },
    Register({data, ok, err}) {
        this.req({type: 'POST', url: 'api/register', data, ok, err});
    },
    LostPassword({data, ok, err}) {
        this.req({type: 'POST', url: 'api/lost-password', data, ok, err});
    },
    Logout({data, ok, err}) {
        this.req({type: 'POST', url: 'api/logout', data, ok, err});
    }
};

