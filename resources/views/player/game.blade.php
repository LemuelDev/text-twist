@extends('player.layout')

@section('content')
  {{-- content --}}
  <nav class="flex justify-end max-md:justify-center pr-4 items-center pt-6 pb-4">
    {{-- <div>
        <h4 class="text-lg"> </h4>
    </div> --}}
    <p class="text-white text-lg max-md:text-sm px-4 pt-4">HIGHSCORE: {{$highscore}}</p>
   
    <button class="rounded-md px-4 py-3 outline-none border-none text-white bg-red-700 hover:bg-red-800 max-md:text-sm" onclick="my_modal_10.showModal()">Quit</button>
    <dialog id="my_modal_10" class="modal">
    <div class="modal-box">
        <h3 class="text-lg font-bold">Confirm!</h3>
        <p class="py-4 text-lg">Are you sure you want to Quit?</p>
        <div class="modal-action">
        <form method="dialog grid gap-4">
            <!-- if there is a button in form, it will close the modal -->
            <a href="{{route('player.dashboard')}}" class="rounded-md text-center mr-2 hover:no-underline px-4 py-5 outline-none border-none hover:text-white text-white bg-red-700 hover:bg-red-800">
                Quit
            </a>
            <button class="rounded-md text-center hover:no-underline px-4 py-4 outline-none border-none text-white bg-blue-600 hover:bg-blue-700">Close</button>
        </form>
        </div>
    </div>
    </dialog>
    
</nav>

    <div class="py-8">
        <div class="flex justify-center max-sm:text-center flex-wrap items-center flex-col gap-2 rounded-lg shadow-lg outline-none bg-transparent  md:max-w-[700px] w-full  mx-auto p-8 max-sm:pt-4 max-sm:px-3">
                <!-- Timer -->
            <div class="flex items-center justify-center gap-6 py-4">
                <div id="current_lvl" class="text-lg text-white">
                    LEVEL: 1
                </div>
                <div id="current_points" class="text-lg text-white">
                    POINTS: 0
                </div>
            </div>

            <div id="timer" class="text-lg font-bold mb-4">Time: 60</div>

            <p class="py-2 text-sm font-bold text-white" id="question"></p>

            <!-- Answer Boxes for 3 Words -->
            <div id="answer-boxes" class="space-y-4 mb-4"></div>

            <!-- Letter Selection Box -->
            <div id="letter-box" class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-2 mb-4"></div>

            <!-- Controls -->
            <div class="mt-4">
                <button onclick="clearAnswer()" class="bg-red-700 text-white px-4 py-2 rounded text-lg">Clear</button>
                <button onclick="submitWord()" class="bg-purple-500 text-white px-4 py-2 rounded text-lg">Submit</button>
            </div>

            <!-- Result Message -->
            <div id="result" class="mt-4 font-bold text-lg"></div>
            {{-- <a href="{{route('player.nextLevel')}}" id="nextLevel" class="py-4 px-8 rounded-lg outline-none text-white bg-green text-lg hidden">Next Level</a> --}}
            <!-- Initially hidden Container for solved words and meanings -->
            
            <dialog id="my_modal_41" class="modal">
                <div class="modal-box">
                <h3 class="text-xl max-sm:text-sm font-bold">Correct!</h3>
                <div id="solved-words-container" class="mt-4">
                    <p class="py-4 pt-8 text-center text-green-600 text-xl max-sm:text-sm hidden" id="txtSolve" >🎉 You solved all words!</p>
                    <h3 class="text-sm text-center">Solved Words</h3>
                    <ul id="solved-words-list" class="text-sm text-center pt-2"></ul>
                </div>
                <div class="modal-action">
                    <form method="dialog">
                    <!-- if there is a button in form, it will close the modal -->
                    <button class="btn" id="nextBtn">Close</button>
                    </form>
                </div>
            </dialog>
        </div>
    </div>

    
    {{-- <dialog id="my_modal_40" class="modal">
        <div class="modal-box">
        <h3 class="text-xl font-bold">Success!</h3>
        <p class="py-4 pt-8 text-center text-green-600 text-xl">🎉 You solved all words!</p>
        <p class="py-4 text-center text-white text-lg">Proceed to next level.</p>
        <div class="modal-action">
            <form method="dialog">
            <!-- if there is a button in form, it will close the modal -->
            <button class="btn" onclick="nextLevel()">Proceed</button>
            </form>
        </div>
        </div>
    </dialog> --}}

    <script>
        // Example words (3 words to solve)
        let highestLevel = parseInt(@json($lvl_cleared));
        let  highScore = parseInt(@json($highscore));
        let lvl = 1;
        let hgh_lvl = lvl;
        let id = lvl;
        let mode = @json($mode);
        let points = 0;
        let words = @json($shuffledWords); // This is the array of objects [{jumbled: "..."}, ...]
        let selectedLetters = [];
        let selectedButtonsHistory = [];
        let solvedWords = Array(words.length).fill(false);
        let jumbledLetters = shuffleWord(words.join("")); // Combine all letters and shuffle
        let wordsMeaning = @json($wordMeanings); 
        let timerPaused = false;  // To track if the timer is paused
        // Function to display answer boxes and letters
        let firstQuestion = @json($question);
        let question;

        function playSound(soundName) {
            const audio = new Audio("{{ asset('sounds/') }}" + `/${soundName}.mp3`);
            audio.play()
                .catch(error => {
                    console.warn(`Sound playback blocked for ${soundName}:`, error);
                    // This often happens if autoplay is attempted without user interaction
                });
        }

        function setupGame() {
            document.getElementById('current_lvl').innerHTML = `LEVEL: ${lvl}`;
            document.getElementById("question").innerHTML = typeof question === 'undefined' ? firstQuestion : question;
            let answerBoxContainer = document.getElementById("answer-boxes");
            answerBoxContainer.innerHTML = "";

           console.log(words);
           console.log(wordsMeaning);
            console.log(question);
            

            // Create answer boxes for 3 words
            words.forEach((word, wordIndex) => {
                let wordContainer = document.createElement("div");
                wordContainer.className = "flex justify-center space-x-2";

                for (let i = 0; i < word.length; i++) {
                    let box = document.createElement("div");
                    box.className = "w-12 h-12 border-2 border-gray-500 text-xl text-black font-bold flex justify-center items-center bg-gray-200";
                    box.dataset.index = wordIndex; // Store which word this box belongs to
                    wordContainer.appendChild(box);
                }

                answerBoxContainer.appendChild(wordContainer);
            });

            // Create letter buttons
            let letterBoxContainer = document.getElementById("letter-box");
            letterBoxContainer.innerHTML = "";
            jumbledLetters.split("").forEach((letter) => {
                let button = document.createElement("button");
                button.className = "w-12 h-10 p-1 bg-blue-400 text-white text-xl font-bold rounded";
                button.innerText = letter;
                button.dataset.letter = letter;
                button.onclick = () => selectLetter(letter, button);
                letterBoxContainer.appendChild(button);
            });
        }

        // Shuffle word function
        function shuffleWord(word) {
            return word.split("").sort(() => Math.random() - 0.5).join("");
        }

        // Handle selecting a letter
        function selectLetter(letter, button) { // 'button' here is the HTML button element
            if (selectedLetters.length < getCurrentWord().length) {
                selectedLetters.push(letter); // Still pushing just the string
                selectedButtonsHistory.push(button); // <--- ADD THIS LINE: Store the button reference
                updateAnswerBoxes();
                button.disabled = true;
                button.classList.add("opacity-50");
            }
        }

        // Get the first unsolved word
        function getCurrentWord() {
            for (let i = 0; i < words.length; i++) {
                if (!solvedWords[i]) return words[i];
            }
            return null;
        }

        // Update answer boxes
        function updateAnswerBoxes() {
            let wordIndex = solvedWords.indexOf(false); // Get first unsolved word
            let boxes = document.querySelectorAll(`#answer-boxes div:nth-child(${wordIndex + 1}) div`);
            boxes.forEach((box, index) => {
                box.innerText = selectedLetters[index] || "";
            });
        }

        // Clear selected answer
        // function clearAnswer() {
        //     selectedLetters = [];
        //     document.querySelectorAll("#letter-box button").forEach(btn => {
        //         btn.disabled = false;
        //         btn.classList.remove("opacity-50");
        //     });
        //     updateAnswerBoxes();
        // }

        // Clear selected answer (removes one letter at a time)
        function clearAnswer() {
            if (selectedLetters.length > 0) {
                // 1. Remove the last selected letter (string) from the main array
                selectedLetters.pop(); // This keeps selectedLetters as an array of strings

                // 2. Remove the corresponding button element from the history array
                const lastUsedButton = selectedButtonsHistory.pop();

                // 3. Re-enable the specific button
                if (lastUsedButton) { // Ensure a button was actually retrieved
                    lastUsedButton.disabled = false;
                    lastUsedButton.classList.remove("opacity-50");
                    // Optional: Remove any other 'selected' classes you might have
                    // lastUsedButton.classList.remove("selected-state-class");
                }
            }
            // 4. Update the displayed answer boxes
            updateAnswerBoxes();
        }
        
function nextLevel() {
    console.log("Next Words Triggered");
    fetch(`/game/${mode}/next-level/${id}`, {
        method: 'GET', // Change POST to GET
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log(data); // Debug: Log response data to check if it's coming as expected

        // Check for the "completed" status from the backend
        if (data.status === 'completed') {
          
            // The rest of the game-related logic will not run because the game is over.
            // You can add logic here to update the modal with high scores if your backend sends them.
            // For example:
            document.getElementById('hgh_lvl1').textContent = `Highest Level: ${hgh_lvl}`;
            document.getElementById('hgh_pts1').textContent = `Highest Points: ${points}`;
            let route = `/player/gameOver/${hgh_lvl}/${points}`; // Adjust according to your route structure
            document.getElementById("gameComplete").href = route;
            document.getElementById('my_modal_40').showModal();
            disableLetterButtons(); // Disable input when time is up
            // We can stop here, no need to proceed with setting up the next level.
            return;
        }

        // If it's not "completed", it means there's a next level.
        // Proceed with your original logic to set up the next level.
        question = data.question;
        wordsMeaning = data.wordMeanings;
        words = data.shuffledWords;
        lvl = data.nextLevel;
        hgh_lvl = data.nextLevel > hgh_lvl ? data.nextLevel : hgh_lvl;
        id = data.nextLevel;
        solvedWords = Array(words.length).fill(false);
        selectedLetters = [];
        selectedButtonsHistory = [];
        jumbledLetters = shuffleWord(words.join(""));
        setupGame();

        // Update UI elements for the new level
        document.getElementById('solved-words-list').innerHTML = "";
        let nextBtn = document.getElementById("nextBtn");
        nextBtn.innerHTML = 'Close';
        nextBtn.onclick = null;
        let txtSolve = document.getElementById('txtSolve');
        txtSolve.classList.add('hidden');

        // Restart the timer for the next level
        startTimer();

    })
    .catch(error => {
        console.error("Error fetching next level:", error);
    });
    
    // Play sound, but only if the game isn't over.
    // This part should be inside the .then() block to ensure it only plays on a successful level up.
    // For simplicity, you can keep it outside, but be aware it will play even if the game is completed.
    playSound('level-up');
}

        // Submit and check word
        function submitWord() {
            let currentWordIndex = solvedWords.indexOf(false);
            let userWord = selectedLetters.join("");
            let correctWord = words[currentWordIndex];

            console.log("User word:", userWord);
            console.log("Correct word:", correctWord);
            console.log("Current word index:", currentWordIndex);

            if (userWord === correctWord) {
                solvedWords[currentWordIndex] = true;
                document.getElementById("result").innerText = `✅ Correct! Word ${currentWordIndex + 1} solved!`;
                if(mode == "easy"){
                    points += 20;
                }else if(mode == "intermediate"){
                    points += 50;
                }else {
                    points += 70;
                }
                document.getElementById("current_points").innerHTML = `POINTS: ${points} `

                 lockAnswerBoxes(currentWordIndex);          
                disableLetterButtons();
                playSound('success')
                pauseTimer();
                 // Show the solved word and its meaning at the bottom
                    
                 displaySolvedWord(currentWordIndex);
                 document.getElementById('my_modal_41').showModal();
                 let nextBtn = document.getElementById("nextBtn");
                 nextBtn.onclick = resumeTimer;

                 if (solvedWords.every(Boolean)) {
                    let nextBtn = document.getElementById("nextBtn");
                    nextBtn.innerHTML = 'Proceed';
                    nextBtn.onclick = nextLevel; // Corrected line
                    let txtSolve = document.getElementById('txtSolve');
                    txtSolve.classList.remove('hidden'); // Corrected line
                    pauseTimer();
                    document.getElementById('my_modal_41').showModal();
                    document.getElementById("result").innerText = ``;
                      if(mode == "easy"){
                        timeLeft += 10;
                    }else if(mode == "intermediate"){
                        timeLeft += 20;
                    }else {
                        timeLeft += 40;
                    }
                    lvl++;
                }
            } else {
                document.getElementById("result").innerText = "❌ Incorrect! Try again.";
                selectedLetters = [];
                document.querySelectorAll("#letter-box button").forEach(btn => {
                    btn.disabled = false;
                    btn.classList.remove("opacity-50");
                });
                updateAnswerBoxes();
                playSound('wrong-ans')
            }

            selectedLetters = [];
            document.querySelectorAll("#letter-box button").forEach(btn => {
                btn.disabled = false;
                btn.classList.remove("opacity-50");
            });
        }

        function displaySolvedWord(index) {
            // Get the word and meaning from the 'wordsMeaning' array using the index
            let solvedWord = wordsMeaning[index].word;
            let wordMeaning = wordsMeaning[index].meaning;

            // Create a new list item for the solved word and meaning
            let listItem = document.createElement('li');
            listItem.innerHTML = `<strong>${solvedWord}</strong>: ${wordMeaning}`;

            // Append the list item to the solved words container
            document.getElementById('solved-words-list').appendChild(listItem);
        }

      // Function to pause the timer
        function pauseTimer() {
            clearInterval(timer);  // Stop the current timer
        }





        function disableLetterButtons() {
        document.querySelectorAll("#letter-box button").forEach(btn => {
            btn.disabled = true;
            btn.classList.add("opacity-50");
        });
        }

        // Lock solved word answer boxes
        function lockAnswerBoxes(index) {
            let boxes = document.querySelectorAll(`#answer-boxes div:nth-child(${index + 1}) div`);
            boxes.forEach(box => {
                box.classList.add("bg-green-300");
            });
        }


        let timer;
        let timeLeft = 60; // Set your time limit in seconds

        function resumeTimer() {
    // Check if a timer is not already running
    if (!timer) {
        // Start a new interval using the existing timeLeft value
        timer = setInterval(() => {
            timeLeft--;
            updateTimerDisplay();

            if (timeLeft <= 0) {
                clearInterval(timer);
                // Your game over logic here
                if(hgh_lvl > highestLevel){
                    document.getElementById('hgh_lvl').innerHTML = `NEW CLEARED LEVEL: ${hgh_lvl}`
                } else {
                    document.getElementById('hgh_lvl').innerHTML = `CLEARED LEVEL: ${hgh_lvl}`
                }
                if (points > highScore){
                     document.getElementById('hgh_pts').innerHTML = `NEW HIGH SCORE: ${points}`
                } else {
                     document.getElementById('hgh_pts').innerHTML = `SCORE: ${points}`
                }
                let route = `/player/gameOver/${hgh_lvl}/${points}`;
                document.getElementById("gameOver").href = route;
                document.getElementById('my_modal_39').showModal();
                disableLetterButtons();
                playSound('game-over')
            }
        }, 1000);
    }
}

        function startTimer() {
            clearInterval(timer); // Clear any previous timer to prevent duplication
            timeLeft = 60; // Reset timer
            updateTimerDisplay();

            timer = setInterval(() => {
                timeLeft--;
                updateTimerDisplay();

                if (timeLeft <= 0) {
                    clearInterval(timer);
                    if(hgh_lvl > highestLevel){
                        document.getElementById('hgh_lvl').innerHTML = `NEW CLEARED LEVEL: ${hgh_lvl}`
                    }else {
                        document.getElementById('hgh_lvl').innerHTML = `CLEARED LEVEL: ${hgh_lvl}`
                    }
                    if (points > highScore){
                          document.getElementById('hgh_pts').innerHTML = `NEW HIGH SCORE: ${points}`
                    }else {
                          document.getElementById('hgh_pts').innerHTML = `SCORE: ${points}`
                    }
                    let route = `/player/gameOver/${hgh_lvl}/${points}`; // Adjust according to your route structure
                    document.getElementById("gameOver").href = route;
                    document.getElementById('my_modal_39').showModal();
                    disableLetterButtons(); // Disable input when time is up
                    playSound('game-over')
                }
            }, 1000);
        }

        function updateTimerDisplay() {
            document.getElementById("timer").innerText = `⏰ Time Left: ${timeLeft}s`;
        }

        // Call startTimer() when the game begins
        document.addEventListener("DOMContentLoaded", () => {
            startTimer();
        });

        document.addEventListener("keydown", function (event) {
            if (event.key === "F5" || (event.ctrlKey && event.key === "r")) {
                event.preventDefault();
                alert("Refreshing is disabled while playing!");
            }
        });
        
        history.pushState(null, null, window.location.href);
        window.addEventListener("popstate", function () {
            history.pushState(null, null, window.location.href);
            alert("Going back is disabled during the game!");
        });




        // Initialize game
        setupGame();
    </script>


<dialog id="my_modal_39" class="modal">
    <div class="modal-box">
    <h3 class="text-xl max-sm:text-sm font-bold text-white">Game Over!</h3>
    <p class="py-4 pt-8 text-center text-white text-2xl max-sm:text-sm">⏳ Time's up!</p>
    <p class="py-4 text-center text-white text-sm" id="hgh_lvl"></p>
    <p class="py-4 text-center text-white text-sm" id="hgh_pts"></p>
    <div class="modal-action">
        <a id="gameOver" class="py-4 px-8 rounded-lg outline-none text-white bg-blue-700 hover:bg-blue-800 text-sm no-underline hover:no-underline">BACK TO DASHBOARD</a>
    </div>
    </div>
</dialog>

<dialog id="my_modal_40" class="modal">
    <div class="modal-box">
    <h3 class="text-xl max-sm:text-sm font-bold text-white">Congratulations!</h3>
    <p class="py-4 pt-8 text-center text-white text-2xl max-sm:text-sm"> You cleared all the levels and questions!</p>
    <p class="py-4 text-center text-white text-sm" id="hgh_lvl1"></p>
    <p class="py-4 text-center text-white text-sm" id="hgh_pts1"></p>
    <div class="modal-action">
        <a id="gameComplete" class="py-4 px-8 rounded-lg outline-none text-white bg-blue-700 hover:bg-blue-800 text-sm no-underline hover:no-underline">BACK TO DASHBOARD</a>
    </div>
    </div>
</dialog>


@endsection