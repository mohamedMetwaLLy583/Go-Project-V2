const fs = require('fs');
const file = 'd:/sd/driver/v2-cpanel/well-known/Go_App_API_Postman_Collection.json';
const data = JSON.parse(fs.readFileSync(file, 'utf8'));

const ordersFolder = data.item.find(i => i.name === 'Orders');
if (ordersFolder) {
    // Add my-orders
    if (!ordersFolder.item.find(i => i.name === 'orders/my-orders [GET]')) {
        ordersFolder.item.push({
            name: 'orders/my-orders [GET]',
            request: {
                method: 'GET',
                header: [
                    { key: 'Accept', value: 'application/json', type: 'text' },
                    { key: 'Authorization', value: 'Bearer {{token}}', type: 'text' }
                ],
                url: {
                    raw: '{{base_url}}/api/orders/my-orders',
                    host: ['{{base_url}}'],
                    path: ['api', 'orders', 'my-orders']
                }
            },
            response: []
        });
    }
    
    // Add my-applications
    if (!ordersFolder.item.find(i => i.name === 'orders/my-applications [GET]')) {
        ordersFolder.item.push({
            name: 'orders/my-applications [GET]',
            request: {
                method: 'GET',
                header: [
                    { key: 'Accept', value: 'application/json', type: 'text' },
                    { key: 'Authorization', value: 'Bearer {{token}}', type: 'text' }
                ],
                url: {
                    raw: '{{base_url}}/api/orders/my-applications',
                    host: ['{{base_url}}'],
                    path: ['api', 'orders', 'my-applications']
                }
            },
            response: []
        });
    }

    // Update orders [POST] to include salary_type
    const storeOrder = ordersFolder.item.find(i => i.name === 'orders [POST]');
    if (storeOrder && storeOrder.request.body && storeOrder.request.body.raw) {
        try {
            let body = JSON.parse(storeOrder.request.body.raw);
            if (!body.salary_type) {
                body.salary_type = 'monthly';
                storeOrder.request.body.raw = JSON.stringify(body, null, 4);
            }
        } catch (e) {
            console.error('body not JSON');
        }
    }
}

fs.writeFileSync(file, JSON.stringify(data, null, 4));
console.log('Postman collection updated successfully!');
