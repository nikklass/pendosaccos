<template>

	<div class="chat-widget-wrapper">
		
		<div class="new_message_head">
	        <div class="col-sm-4">
	            <div class="pull-left">
	                <button>
	                	<i class="fa fa-plus-square-o" aria-hidden="true"></i> Start New Message
	                </button>
	            </div>
	        </div>
	        <div class="col-sm-4 text-center">
	    		<span v-if="chatStore.currentChatUser !== null">
	    		{{ chatStore.currentChatUser.first_name | capitalize }} 
	    		{{ chatStore.currentChatUser.last_name | capitalize }}
	    		</span>
	        </div>
	        <div class="col-sm-4">
	            <div class="pull-right">
	                <div class="dropdown">
	                    <button class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                        <i class="fa fa-cogs" aria-hidden="true"></i> Chat Options
	                        <span class="caret"></span>
	                    </button>
	                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
	                        <li><a href="#">Action</a></li>
	                        <li><a href="#">Profile</a></li>
	                        <li><a href="#">Logout</a></li>
	                    </ul>
	                </div>
	            </div>
	        </div>
	    </div>

	</div>

</template>


<script>

import { mapState } from 'vuex'

export default {
	computed: {
		...mapState({
			chatStore: state => state.chats
		})
	}
}

</script>


<style>
 
</style>