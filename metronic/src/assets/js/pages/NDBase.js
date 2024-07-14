var NDBase = function () {
    console.log('loader_base');
    var data = {};
    var routers = {};


    return {
        init: (param) => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            this.data = param;
            if (typeof param.routers !== 'undefined') {
                routers = param.routers;
            }

            return this;
        },
        getData: () => {
            return this.data;
        },
        getRouter: (key) => {
            try {
                return routers[key];
            } catch (e) {
                return null;
            }
        }
    }
}();
module.exports = NDBase;
