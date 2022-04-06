'user strict';

const DB 	= require('./db');
const path 	= require('path');
const fs 	= require('fs');

class Helper{

	constructor(app){
		this.db = DB;
	}

	async addSocketId(userId, userSocketId){
	    console.log(userId)
	    console.log(userSocketId)
		try {
			return await this.db.query(`UPDATE users SET socket_id = ?, online= ? WHERE id = ?`, [userSocketId,'1',userId]);
		} catch (error) {
			console.log(error);
			return null;
		}
	}

	async logoutUser(userSocketId){
		try {
			//return await this.db.query(`UPDATE users SET socket_id = ?, online= ? WHERE socket_id = ?`, ['','0',userSocketId]);
			return await this.db.query(`UPDATE users SET socket_id = ?, online= ? WHERE id = ?`, ['','0',userSocketId]);
		} catch (error) {
			console.warn(error);
			return null;
		}

	}

	async CreateTrack(data){
		try {
			//return await this.db.query(`UPDATE users SET socket_id = ?, online= ? WHERE socket_id = ?`, ['','0',userSocketId]);
			return await this.db.query(`UPDATE order_locations SET lat =  ?, lng = ? WHERE order_id = ?`, [data.lat,data.lng,data.order_id]);
		} catch (error) {
			console.warn(error);
			return null;
		}

	}
	async track_order(data){
		try {
			if(data.status == 2){
				return await this.db.query('SELECT user_id From orders Where id = ? AND status= ? ',[data.order_id,2]);
			}else if(data.status == 3){
				return await this.db.query('SELECT user_id From orders Where id = ? AND status= ? ',[data.order_id,3]);
			}
			//return await this.db.query(`UPDATE users SET socket_id = ?, online= ? WHERE socket_id = ?`, ['','0',userSocketId]);
		} catch (error) {
			console.warn(error);
			return null;
		}

	}
	isUserConnected(userId){
		try {
			return Promise.all([
				this.db.query(`SELECT id, first_name, socket_id, online, updated_at FROM users WHERE id = ?`, [userId])
			]).then( (response) => {
				return {
					userData : response[0]
				};
			}).catch( (error) => {
				console.warn(error);
				console.log(1111);
				return (null);
			});
		} catch (error) {
			console.warn(error);
			return null;
		}
	}

}
module.exports = new Helper();
