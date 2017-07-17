<template>
	
    <div class="message_write">

	        <textarea 
	        	class="form-control" 
	        	placeholder="Enter message" 
	        	v-model="message"
	        	@keydown.enter.prevent="handleAddChat">		
	        </textarea>
	        <div class="clearfix"></div>
	        <div class="chat_bottom">
	        	<a href="#" class="pull-left upload_btn">
	        		<i class="fa fa-cloud-upload" aria-hidden="true"></i>
					Add Files
				</a>
	            <a @click.prevent="handleAddChat" class="pull-right btn btn-success">Send</a>
			</div>

    </div>


</template>

<script>
	import { mapState } from 'vuex'
	//import Pusher from 'pusher-js'

	export default {
		
		data() {
            return {
				message: '',
                addLoading: false,
                pusher: null,
                channel: null
            }
        },

        created() {
        	/*this.pusher = new Pusher('3b731e398e444a456164', {
        		cluster: 'ap2',
      			encrypted: true
        	})
        	let that = this
        	this.channel = this.pusher.subscribe('chat_channel')
        	this.channel.bind('chat-message', function(data) {
        		that.$emit('incoming_chat', data)
        	})
        	this.$on('incoming_chat', function(chatMessage) {
        		this.incoming_chat(chatMessage)
        	})*/
        },

        computed: {
			...mapState({
				chatStore: state => state.chats,
				authUserStore: state => state.authUser
			})
		},
		
		methods: {

			handleAddChat() {
				
				if (this.message !== null) {
					
					let postData = {
						'message': this.message,
						'receiver_id': this.chatStore.currentChatUser.id
					}

					//post form data
	                this.$store.dispatch('addNewChatToConversation', postData)
						.then(response => {
							console.log(response)
							this.message = null
							//scroll to view
							let element = document.getElementById('chat-widget-wrapper')
							element.scrollIntoView(false)
						})
                    	.catch(error => console.log(error));
					
				}

			},

			incomngChat(chatMessage) {
				if (this.chatStore.currentChatUser.id === chatMessage.message.sender_id) {
					if (this.chatMessage.message.receiver.id === this.authUserStore.authUser.id) {
						//send msg to current user
						this.$store.dispatch('newIncomingChat', chatMessage.message)
							.then(res => {
								let element = document.getElementById('chat-widget-wrapper')
								element.scrollIntoView(false)
							})
						console.log('chatMessage', chatMessage)
					} else {
						console.log('message for other user')
					}
				}
			}
			
		}
	}
</script>

<style>

</style>