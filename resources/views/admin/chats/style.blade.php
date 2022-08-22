<style>
    .chat-app-container {
        max-width: 800px;
        display: block;
        margin: auto;
    }

    .chat-history-container {
        height: 65vh;
        overflow-y: scroll;
    }

    .chat-history-container::-webkit-scrollbar {
        width: 0.35rem;
        border-radius: 2%;
    }

    .chat-history-container::-webkit-scrollbar-thumb {
        background-color: #113961;
        border-radius: 10px;
    }

    .message-container {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 5px 5px 5px #ddd;
        width: 60%;
    }

    .author-title-container {
        font-size: 0.85rem;
    }

    .date-chat-container {
        font-size: 0.7rem;
    }

    .chat-send-message:disabled {
        cursor: not-allowed;
    }
</style>
