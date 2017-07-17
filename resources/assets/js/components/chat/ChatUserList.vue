<template>
	<div class="wrapper" id="chat-user-list-wrapper">

		<ul class="list-group">

			<li class="left clearfix list-group-item"
				:class="userActiveStyle(user) ? 'active' : ''" 
				@click.prevent="changeChatUser(user)" 
				v-if="user.id !== authUserStore.authUser.id"
				v-for="user in chatStore.userList">

	            <span class="chat-img pull-left">
	                 <img src="./../../assets/images/nikk.jpg" :alt="user.first_name" class="img-circle">
	            </span>
	            <div class="chat-body clearfix">
	                <div class="header_sec">
	                    <strong class="primary-font">{{ user.first_name }} {{ user.last_name }}</strong> 
	                    <strong class="pull-right">09:45AM</strong>
	                </div>
	                <div class="contact_sec">
	                    <strong class="primary-font">(123) 123-456</strong> <span class="badge pull-right">3</span>
	                </div>
	            </div>

	        </li> 

        </ul>

	</div>
</template>

<script>
	import { mapState } from 'vuex';

	export default {
		
		computed: {
			...mapState({
				chatStore: state => state.chats,
				authUserStore: state => state.authUser
			})
		},

		methods: {
			userActiveStyle(user) {
				if (this.chatStore.currentChatUser === null) {
					return false
				}
				if (this.chatStore.currentChatUser === user.id) {
					return true
				}
				return false
			},
			changeChatUser(user) {
				this.$store.dispatch('setCurrentChatUser', user)
			}
		}

	}

</script>

<style scoped>
	#chat-user-list-wrapper li.active{ background: #277E8E; }
</style>