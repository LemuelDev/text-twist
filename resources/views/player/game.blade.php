@extends('player.layout')

@section('content')
  {{-- content --}}
  <nav class="flex justify-end pr-4 items-center pt-6 pb-4">
    {{-- <div>
        <h4 class="text-lg"> </h4>
    </div> --}}
    <p class="text-white text-lg px-4 pt-4">HIGHSCORE: {{$highscore}}</p>
   
    <button class="btn btn-error" onclick="my_modal_10.showModal()">Quit</button>
    <dialog id="my_modal_10" class="modal">
    <div class="modal-box">
        <h3 class="text-lg font-bold">Confirm!</h3>
        <p class="py-4 text-lg">Are you sure you want to Quit?</p>
        <div class="modal-action">
        <form method="dialog">
            <!-- if there is a button in form, it will close the modal -->
            <a href="{{route('player.dashboard')}}" class="btn btn-error hover:no-underline">
                Quit
            </a>
            <button class="btn">Close</button>
        </form>
        </div>
    </div>
    </dialog>
    
</nav>

    <div class="pt-8">
        <div class="flex justify-center flex-wrap items-center flex-col gap-2 rounded-lg shadow-lg outline-none bg-transparent  max-w-[700px] mx-auto p-8">
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
            <div id="letter-box" class="flex justify-center flex-wrap gap-3 space-x-2 mb-4"></div>

            <!-- Controls -->
            <div class="mt-4">
                <button onclick="clearAnswer()" class="bg-red-500 text-white px-4 py-2 rounded text-lg">Clear</button>
                <button onclick="submitWord()" class="bg-blue-500 text-white px-4 py-2 rounded text-lg">Submit</button>
            </div>

            <!-- Result Message -->
            <div id="result" class="mt-4 font-bold text-lg"></div>
            {{-- <a href="{{route('player.nextLevel')}}" id="nextLevel" class="py-4 px-8 rounded-lg outline-none text-white bg-green text-lg hidden">Next Level</a> --}}
            <!-- Initially hidden Container for solved words and meanings -->
            
            <dialog id="my_modal_41" class="modal">
                <div class="modal-box">
                <h3 class="text-xl font-bold">Correct!</h3>
                <div id="solved-words-container" class="mt-4">
                    <h3 class="text-sm text-center">Solved Words</h3>
                    <ul id="solved-words-list" class="text-sm text-center pt-2"></ul>
                </div>
                <div class="modal-action">
                    <form method="dialog">
                    <!-- if there is a button in form, it will close the modal -->
                    <button class="btn">Close</button>
                    </form>
                </div>
            </dialog>
        </div>
    </div>

    
    <dialog id="my_modal_40" class="modal">
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
    </dialog>

    <script>
        // Example words (3 words to solve)
        let highestLevel = parseInt(@json($lvl_cleared));
        let  highScore = parseInt(@json($highscore));
        let lvl = 1;
        let id = lvl;
        let points = 0;
        let words = @json($shuffledWords); // This is the array of objects [{jumbled: "..."}, ...]
        let selectedLetters = [];
        let solvedWords = [false, false, false]; // Track solved words
        let jumbledLetters = shuffleWord(words.join("")); // Combine all letters and shuffle
        let wordsMeaning = @json($wordMeanings); 
        let timerPaused = false;  // To track if the timer is paused
        // Function to display answer boxes and letters
        let firstQuestion = @json($question);
        let question;
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
        function selectLetter(letter, button) {
            if (selectedLetters.length < getCurrentWord().length) {
                selectedLetters.push(letter);
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
        function clearAnswer() {
            selectedLetters = [];
            document.querySelectorAll("#letter-box button").forEach(btn => {
                btn.disabled = false;
                btn.classList.remove("opacity-50");
            });
            updateAnswerBoxes();
        }
        
        function nextLevel() {
            console.log("Next Words Triggered");
            fetch(`/player/next-level/${id}`, {
                method: 'GET',  // Change POST to GET
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
                console.log(data);  // Debug: Log response data to check if it's coming as expected
                question = data.question;
                wordsMeaning = data.wordMeanings
                words = data.shuffledWords; // Update words array with new words
                lvl = data.nextLevel;
                id = data.nextLevel; // Update level
                solvedWords = [false, false, false]; // Reset solved words tracker
                selectedLetters = []; // Clear selected letters
                jumbledLetters = shuffleWord(words.join("")); // Shuffle new words
                setupGame(); // Reload UI with new words
            })
            .catch(error => {
                console.error("Error fetching next level:", error);
            });

            document.getElementById('solved-words-list').innerHTML = "";
            startTimer();  // Restart the timer for the next level
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
                points += 100;
                document.getElementById("current_points").innerHTML = `POINTS: ${points} `

                 lockAnswerBoxes(currentWordIndex);          
                disableLetterButtons();

                 // Show the solved word and its meaning at the bottom
                    
                 displaySolvedWord(currentWordIndex);
                 document.getElementById('my_modal_41').showModal();
                if (solvedWords.every(Boolean)) {

                    pauseTimer();
                    document.getElementById('my_modal_41').close();
                    document.getElementById('my_modal_40').showModal();
                    document.getElementById("result").innerText = ``;
                    timeLeft += 30;
                    lvl++;
                    
                    
                }
            } else {
                document.getElementById("result").innerText = "❌ Incorrect! Try again.";
             
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

        function startTimer() {
            clearInterval(timer); // Clear any previous timer to prevent duplication
            timeLeft = 60; // Reset timer
            updateTimerDisplay();

            timer = setInterval(() => {
                timeLeft--;
                updateTimerDisplay();

                if (timeLeft <= 0) {
                    clearInterval(timer);
                    if(lvl > highestLevel){
                        document.getElementById('hgh_lvl').innerHTML = `NEW CLEARED LEVEL: ${lvl}`
                    }else {
                        document.getElementById('hgh_lvl').innerHTML = `CLEARED LEVEL: ${lvl}`
                    }
                    if (points > highScore){
                          document.getElementById('hgh_pts').innerHTML = `NEW HIGH SCORE: ${points}`
                    }else {
                          document.getElementById('hgh_pts').innerHTML = `SCORE: ${points}`
                    }
                    let route = `/player/gameOver/${lvl}/${points}`; // Adjust according to your route structure
                    document.getElementById("gameOver").href = route;
                    document.getElementById('my_modal_39').showModal();
                    disableLetterButtons(); // Disable input when time is up
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
    <h3 class="text-xl font-bold text-red-600">Game Over!</h3>
    <p class="py-4 pt-8 text-center text-red-600 text-2xl">⏳ Time's up!</p>
    <p class="py-4 text-center text-white text-sm" id="hgh_lvl"></p>
    <p class="py-4 text-center text-white text-sm" id="hgh_pts"></p>
    <div class="modal-action">
        <a id="gameOver" class="py-4 px-8 rounded-lg outline-none text-white bg-blue-700 hover:bg-blue-800 text-sm no-underline hover:no-underline">BACK TO DASHBOARD</a>
    </div>
    </div>
</dialog>


@endsection