<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class ApiController extends ResourceController
{
    protected $format = 'json';

    public function vocabularies()
    {
        $db = \Config\Database::connect();

        $data = $db->table('words')
            ->where('id_category', 1)
            ->get()
            ->getResultArray();

        return $this->respond($data);
    }

    public function objectWords()
{
    $db = \Config\Database::connect();

    $data = $db->table('words')
        ->where('id_category', 4)
        ->get()
        ->getResultArray();

    return $this->respond($data);
}

    public function categories()
    {
        $db = \Config\Database::connect();

        $data = $db->table('categories')
            ->select('id_category, category_name, description')
            ->get()
            ->getResultArray();

        return $this->respond($data);
    }

    public function words()
    {
        $db = \Config\Database::connect();

        $data = $db->table('words')
            ->select('id_words, id_category, english_word, indonesian_word, image, audio')
            ->get()
            ->getResultArray();

        return $this->respond($data);
    }

  public function rewards()
{
    $db = \Config\Database::connect();

    $data = $db->table('rewards')
        ->select('id_reward, reward_name, sticker_image, required_stars')
        ->where('required_stars IS NOT NULL')
        ->orderBy('required_stars', 'ASC')
        ->get()
        ->getResultArray();

    return $this->respond($data);
}

    public function videos()
    {
        $db = \Config\Database::connect();

        $data = $db->table('videos')
            ->get()
            ->getResultArray();

        return $this->respond($data);
    }

    public function fruitQuiz()
{
    $db = \Config\Database::connect();

    $questions = $db->table('questions')
        ->select('id_question, id_quiz, question_text')
        ->where('id_quiz', 2)
        ->get()
        ->getResultArray();

    foreach ($questions as &$question) {
        $options = $db->table('options')
            ->select('option_text, is_correct')
            ->where('id_question', $question['id_question'])
            ->get()
            ->getResultArray();

        $answer = '';

        foreach ($options as $option) {
            if ($option['is_correct'] == 1) {
                $answer = $option['option_text'];
            }
        }

        $question['answer'] = $answer;
        $question['image'] = 'assets/images/fruits&vegetables/' .
            strtolower(str_replace(' ', '_', $answer)) . '.png';
        $question['options'] = array_column($options, 'option_text');
    }

    return $this->respond($questions);
}

public function animalQuiz()
{
    $db = \Config\Database::connect();

    $questions = $db->table('questions')
        ->select('id_question, id_quiz, question_text')
        ->where('id_quiz', 1)
        ->get()
        ->getResultArray();

    foreach ($questions as &$question) {

        $options = $db->table('options')
            ->select('option_text, is_correct')
            ->where('id_question', $question['id_question'])
            ->get()
            ->getResultArray();

        $answer = '';

        foreach ($options as $option) {
            if ($option['is_correct'] == 1) {
                $answer = $option['option_text'];
            }
        }

        // DEFAULT IMAGE NAME
        $imageName = strtolower(str_replace(' ', '_', $answer));

        // INDONESIAN -> ENGLISH
  $translations = [
    'bebek' => 'duck',
    'kelinci' => 'rabbit',
    'ikan' => 'fish',
    'anjing' => 'dog',
    'kucing' => 'cat',
    'sapi' => 'cow',
];

        if (array_key_exists(strtolower($answer), $translations)) {
            $imageName = $translations[strtolower($answer)];
        }

        $question['answer'] = $answer;

        $question['image'] =
            'assets/images/animals/' . $imageName . '.png';

        $question['options'] =
            array_column($options, 'option_text');
    }

    return $this->respond($questions);
}

public function objectQuiz()
{
    $db = \Config\Database::connect();

    $questions = $db->table('questions')
        ->select('id_question, id_quiz, question_text')
        ->where('id_quiz', 4)
        ->get()
        ->getResultArray();

    foreach ($questions as &$question) {

        $options = $db->table('options')
            ->select('id_option, id_question, option_text, is_correct')
            ->where('id_question', $question['id_question'])
            ->get()
            ->getResultArray();

        $question['answer'] = '';

        foreach ($options as $option) {
            if ($option['is_correct'] == 1) {
                $question['answer'] = $option['option_text'];
            }
        }

        $imageName = strtolower(
            str_replace(' ', '_', $question['answer'])
        );

        $question['image'] =
            'assets/images/objects/' . $imageName . '.png';

        $question['options'] =
            array_column($options, 'option_text');
    }

    return $this->respond($questions);
}

public function familyQuiz()
{
    $db = \Config\Database::connect();

    $questions = $db->table('questions')
        ->select('id_question, id_quiz, question_text')
        ->where('id_quiz', 3)
        ->get()
        ->getResultArray();

    foreach ($questions as &$question) {

        $options = $db->table('options')
            ->select('option_text, is_correct')
            ->where('id_question', $question['id_question'])
            ->get()
            ->getResultArray();

        $answer = '';

        foreach ($options as $option) {
            if ($option['is_correct'] == 1) {
                $answer = $option['option_text'];
            }
        }

        $imageName = strtolower(str_replace(' ', '_', $answer));

        $translations = [
            'ayah' => 'father',
            'ibu' => 'mother',
            'nenek' => 'grandmother',
            'kakek' => 'grandfather',
            'adik' => 'little_sister',
            'kakak laki-laki' => 'brother',
        ];

        if (array_key_exists(strtolower($answer), $translations)) {
            $imageName = $translations[strtolower($answer)];
        }

        $question['answer'] = $answer;

        $question['image'] =
            'assets/images/family/' . $imageName . '.png';

        $question['options'] =
            array_column($options, 'option_text');
    }

    return $this->respond($questions);
}

public function greetingQuiz()
{
    $db = \Config\Database::connect();

    $questions = $db->table('questions')
        ->select('id_question, id_quiz, question_text')
        ->where('id_quiz', 6)
        ->get()
        ->getResultArray();

    foreach ($questions as &$question) {

        $options = $db->table('options')
            ->select('id_option, id_question, option_text, is_correct')
            ->where('id_question', $question['id_question'])
            ->get()
            ->getResultArray();

        $question['answer'] = '';

        foreach ($options as $option) {
            if ($option['is_correct'] == 1) {
                $question['answer'] = $option['option_text'];
            }
        }

        $imageName = strtolower(
            str_replace(' ', '_', $question['answer'])
        );

        $question['image'] =
            'assets/images/greeting/' . $imageName . '.png';

        $question['options'] =
            array_column($options, 'option_text');
    }

    return $this->respond($questions);
}

public function colourQuiz()
{
    $db = \Config\Database::connect();

    $questions = $db->table('questions')
        ->select('id_question, id_quiz, question_text')
        ->where('id_quiz', 5)
        ->get()
        ->getResultArray();

    foreach ($questions as &$question) {

        $options = $db->table('options')
            ->select('id_option, id_question, option_text, is_correct')
            ->where('id_question', $question['id_question'])
            ->get()
            ->getResultArray();

        $question['answer'] = '';

        foreach ($options as $option) {
            if ($option['is_correct'] == 1) {
                $question['answer'] = $option['option_text'];
            }
        }

        // safer image mapping
        $imageName = strtolower(str_replace(' ', '_', trim($question['answer'])));

        if ($imageName == '') {
            $imageName = 'default';
        }

        $imagePath = 'assets/images/colour/' . $imageName . '.png';

        $question['image'] = $imagePath;

        $question['options'] = array_column($options, 'option_text');
    }

    return $this->respond($questions);
}

public function createUser()
{
    $db = \Config\Database::connect();

    $name = $this->request->getPost('name');

    if (!$name) {
        return $this->respond([
            'status' => false,
            'message' => 'Name is required'
        ]);
    }

    $db->table('users')->insert([
        'name' => $name,
        'created_at' => date('Y-m-d H:i:s')
    ]);

    $userId = $db->insertID();

    return $this->respond([
        'status' => true,
        'id_user' => $userId,
        'name' => $name
    ]);
}

public function saveQuizResult()
{
    $db = \Config\Database::connect();

    $idQuiz = $this->request->getPost('id_quiz');
    $idUser = $this->request->getPost('id_user');
    $stars = $this->request->getPost('stars');

    if (!$idQuiz || !$idUser || !$stars) {
        return $this->respond([
            'status' => false,
            'message' => 'Data incomplete'
        ]);
    }

    $db->table('quiz_result')->insert([
        'id_quiz' => $idQuiz,
        'id_user' => $idUser,
        'stars' => $stars,
        'date_taken' => date('Y-m-d H:i:s')
    ]);

    return $this->respond([
        'status' => true,
        'message' => 'Quiz result saved'
    ]);
}

public function unlockReward()
{
    $db = \Config\Database::connect();

    $idUser = $this->request->getPost('id_user');
    $stars  = (int) $this->request->getPost('stars');

    if (!$idUser) {
        return $this->respond([
            'status' => false,
            'message' => 'User not found'
        ]);
    }

    $rewards = $db->table('rewards')
        ->where('required_stars <=', $stars)
        ->get()
        ->getResultArray();

    $unlocked = [];

    foreach ($rewards as $reward) {

        $check = $db->table('unlocked_reward')
            ->where('id_user', $idUser)
            ->where('id_reward', $reward['id_reward'])
            ->get()
            ->getRowArray();

        if (!$check) {

            $db->table('unlocked_reward')->insert([
                'id_user' => $idUser,
                'id_reward' => $reward['id_reward'],
                'unlocked_at' => date('Y-m-d H:i:s')
            ]);

            $unlocked[] = $reward['id_reward'];
        }
    }

    return $this->respond([
        'status' => true,
        'message' => 'Reward unlocked',
        'data' => $unlocked
    ]);
}

public function unlockedRewards()
{
    $db = \Config\Database::connect();

    $idUser = $this->request->getGet('id_user');

    $data = $db->table('unlocked_reward')
        ->where('id_user', $idUser)
        ->get()
        ->getResultArray();

    return $this->respond($data);
}

}