document.addEventListener("DOMContentLoaded", async () => {
    const friends = document.querySelectorAll(".friends");
    if (friends) {
        friends.forEach((friend) => {
            friend.addEventListener("click", async () => {
                handleClearMessage();

                const friendId = friend.getAttribute("data-friend-id");
                const friendName = friend.getAttribute("data-friend-name");

                const friend_name = document.querySelector(".friend_name");
                if (friend_name) {
                    friend_name.innerHTML = friendName;
                }

                await createRoom(friendId);
            });
        });
    }

    const sendMessage = async (message, roomId) => {
        try {
            const response = await axios.post(
                `/api/v1/messages/save`,
                {
                    message: message,
                    room_id: roomId,
                },
                {
                    headers: {
                        Authorization: `Bearer ${access_token}`,
                    },
                }
            );

            const data = response.data;

            if (data.status) {
                handleRightMessage(data.data.message);
            }
        } catch (error) {
            console.error(error);
        }
    };

    function handleRightMessage(message) {
        let html = `<div class="chat-item">
        <div class="row align-items-end justify-content-end">
            <div class="col col-lg-6">
                <div class="chat-bubble chat-bubble-me">
                    <div class="chat-bubble-body">
                        <p>${message}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>`;

        var chat_bubbles = document.querySelector("#chat-bubbles");
        chat_bubbles.insertAdjacentHTML("beforeend", html);
        chat_bubbles.scrollTo({
            left: 0,
            top: chat_bubbles.scrollHeight,
            behavior: "smooth",
        });
    }

    function handleLeftMessage(message) {
        let html = `<div class="chat-item">
        <div class="row align-items-end">
            <div class="col col-lg-6">
                <div class="chat-bubble">
                    <div class="chat-bubble-body">
                        <p>${message}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>`;

        var chat_bubbles = document.querySelector("#chat-bubbles");
        chat_bubbles.insertAdjacentHTML("beforeend", html);
        chat_bubbles.scrollTo({
            left: 0,
            top: chat_bubbles.scrollHeight,
            behavior: "smooth",
        });
    }

    function handleClearMessage() {
        var chat_bubbles = document.querySelector("#chat-bubbles");
        chat_bubbles.innerHTML = "";
    }

    function showHideChatBox(show) {
        if (show == true) {
            document.querySelector("#chatbox").classList.remove("d-none");
        } else {
            document.querySelector("#chatbox").classList.add("d-none");
        }
    }

    const createRoom = async (friendId) => {
        try {
            const response = await axios.post(
                `/api/v1/rooms/create`,
                {
                    friend_id: friendId,
                },
                {
                    headers: {
                        Authorization: `Bearer ${access_token}`,
                    },
                }
            );

            const room = response.data.data;

            console.log(room);

            await loadMessage(room.id, friendId);

            Echo.join(`chat.${room.id}`)
                .here(async (users) => {
                    const type_area = document.querySelector("#type-area");
                    if (type_area) {
                        type_area.addEventListener(
                            "keydown",
                            async function (e) {
                                if (e.key === "Enter") {
                                    let message = this.value;
                                    if (message !== "") {
                                        await sendMessage(message, room.id);

                                        this.value = "";
                                    }
                                }
                            }
                        );
                    }

                    console.log("Join Channel Chat!");
                })
                .listen("SendMessage", (e) => {
                    console.log(e);

                    if (e.userId == friendId) {
                        handleLeftMessage(e.message);
                    }
                })
                .joining((user) => {
                    console.log(user.name);
                })
                .leaving((user) => {
                    console.log(user.name);
                })
                .error((error) => {
                    console.error(error);
                });

            showHideChatBox(true);
        } catch (error) {
            console.log(error);
        }
    };

    const loadMessage = async (roomId, friendId) => {
        try {
            const response = await axios.get(
                `/api/v1/messages/load/${roomId}`,
                {
                    headers: {
                        Authorization: `Bearer ${access_token}`,
                    },
                }
            );

            const data = response.data;

            if (data.status) {
                const chats = data.data;

                chats.forEach((chat) => {
                    if (chat.user_id == friendId) {
                        handleLeftMessage(chat.message);
                    } else {
                        handleRightMessage(chat.message);
                    }
                });
            }
        } catch (error) {
            console.error(error);
        }
    };
});
