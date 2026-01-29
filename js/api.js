/**
 * API Helper for OOP Backend
 * Provides a simple interface to call controller actions
 */
const API = {
    baseURL: 'api/index.php',
    
    /**
     * Call a controller action
     * @param {string} controller - Controller name (e.g., 'product')
     * @param {string} action - Action/method name (e.g., 'fetch', 'add', 'delete')
     * @param {object} data - Additional data to send
     * @returns {Promise} Promise that resolves with response data
     */
    call: function(controller, action, data = {}) {
        return new Promise((resolve, reject) => {
            const params = {
                controller: controller,
                action: action,
                ...data
            };
            
            $.ajax({
                url: this.baseURL,
                type: 'POST',
                data: params,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        resolve(response.data);
                    } else {
                        reject(response.error);
                    }
                },
                error: function(xhr) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        reject(response.error || 'An error occurred');
                    } catch(e) {
                        reject('An error occurred');
                    }
                }
            });
        });
    }
};
