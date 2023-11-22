console.log('debut du script game');
const apiUrl = "https://quizzapi.jomoreschi.fr/api/v1/quiz?limit=5";
let cptQuestions = 0;
let reponseCliquee = false;
let score = 0;
const parent = document.querySelector('.reponses');
let cptclick=0;




function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]];
    }
}

function afficherQuestion(data) {

    
    document.querySelector('.question').textContent = data['quizzes'][cptQuestions]['question']

    const parent = document.querySelector('.reponses');

    const arrAnswers = []

    for (let i = 0; i < 3; i++) {

        arrAnswers.push(data['quizzes'][cptQuestions]['badAnswers'][i]);

    }

    arrAnswers.push(data['quizzes'][cptQuestions]['answer']);


    shuffleArray(arrAnswers)



    for (let i = 0; i < 4; i++) {
        let newLi = document.createElement('li');
        newLi.textContent = arrAnswers[i];
        parent.appendChild(newLi);
    }

    cptclick = 0;
    ajouterEcouteurs(data);

}

function registerScore(game_id, score) {
    const url = '../function/register_score.php';

    // Préparez les données à envoyer
    const data = new URLSearchParams();
    data.append('game_id', game_id);
    data.append('score', score);


    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: data,
    })
        .then(response => response.json())
        .then(json => {
            console.log(json); // Vous pouvez traiter la réponse ici
        })
        .catch(error => {
            console.error('Erreur lors de la requête fetch :', error);
        });
}

document.querySelector('.debut_partie p').addEventListener('click', () => {
    document.querySelector('.debut_partie').classList.add('cacher')
    document.querySelector('.une_question').classList.remove('cacher')

    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            // console.log(data);
            afficherQuestion(data);
            document.querySelector('.suivant').addEventListener('click', () => {
                document.querySelector('.suivant').classList.add('cacher')
                cptQuestions += 1;
                while (parent.firstChild) {
                    parent.removeChild(parent.firstChild);
                }

                if (cptQuestions < data['quizzes'].length) {

                    afficherQuestion(data);
                } else {

                    console.log('Toutes les questions ont été posées');
                    document.querySelector('.une_question').classList.add('cacher')
                    document.querySelector('.fin').classList.remove('cacher')

                    const urlParams = new URLSearchParams(window.location.search);

                    // Récupérer l'ID de la game
                    const gameId = urlParams.get('gameID');
                    registerScore(gameId, score);

                }
            })
        })

})

const ajouterEcouteurs = (data) => {
    document.querySelectorAll('.reponses li').forEach((cliquee) => {
        cliquee.addEventListener('click', () => {
            document.querySelector('.suivant').classList.remove('cacher');

            if (cliquee.textContent == data['quizzes'][cptQuestions]['answer']) {
                cliquee.classList.add('correct-answer')
                if (cptclick === 0) {
                    cptclick += 1;
                    score += 1;
                }

            } else {
                cptclick += 1;
                cliquee.classList.add('wrong-answer')
            }

        });
    });
}


document.querySelector('.fin p').addEventListener('click', () => {
    window.location.href = "../pages/accueil.php";
})

