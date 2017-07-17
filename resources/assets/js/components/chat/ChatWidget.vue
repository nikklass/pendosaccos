<template>

<div id="chat-widget-wrapper">
	
	<div class="chat_area">
	
		<ul class="list-unstyled" v-if="chatStore.conversation.length">

			<li class="left clearfix" 
				:class="isAuthUser(chat.sender_id) ? 'admin_chat' : ''"
				v-for="chat in chatStore.conversation">
			    <span 
			    	class="chat-img1"
			    	:class="isAuthUser(chat.sender_id) ? 'pull-right' : 'pull-left'">
				    <img src="./../../assets/images/nikk.jpg" :alt="chat.sender.first_name" class="img-circle">
				</span>
			    <div 
			    	class="chat-body1 clearfix"
			    	:class="isAuthUser(chat.sender_id) ? 'grey_bg' : 'white_bg'">
			        <p :class="isAuthUser(chat.sender_id) ? 'grey_bg' : ''">{{ chat.message }}</p>
			        <div 
			        	class="chat_time"
			        	:class="isAuthUser(chat.sender_id) ? 'pull-left' : 'pull-right'">
			        	<timeago :since="chat.created_at" :auto-update="60"></timeago>
			        </div>
			    </div>
			</li>

		</ul>
		
		<!-- no conversation selected -->
		<div class="alert alert-info" v-else>
			<h4 class="text-center">No message to display</h4>
		</div>
	
	
	</div>

</div>

</template>

<script>

	import { mapState } from 'vuex'

	export default {
		computed: {
			...mapState({
				chatStore: state => state.chats,
				authUserStore: state => state.authUser
			})
		},
		methods: {
			//check if this is the logged in user or not
			isAuthUser(user_id){
				return user_id === this.authUserStore.authUser.id
			}
		}
	}

</script>

<style scoped>
	.grey_bg{ background: #dedede; }
	.white_bg{ background: #fbf9fa; }
	.chat_time{ padding: 10px; }
</style>