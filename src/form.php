<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./styles/dist.css" />
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
  <title>Document</title>
</head>

<body>
  <div class="basis-[35%] my-8  xl:my-8 order-2 container xl:pr-1 xl:pl-0">
    <h2 class="text-2xl font-bold text-center">
      <?php echo $title; ?>
    </h2>
    <form action=<?php echo $action ?> method="POST" class="mt-8" enctype="multipart/form-data">
      <?php if (!empty($errors)) : ?>
        <ul class="text-red-500">
          <?php foreach ($errors as $error) : ?>
            <li><?php echo $error; ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <div class="grid grid-cols-1 gap-6">
        <div class="block">
          <label for="title" class="text-gray-700">タイトル</label>
          <input type="text" name="title" id="title" value="<?php echo $element['title'] ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
        </div>
        <div class="inline-block">
          <span class="text-gray-700">画像</span>
          <label for="image" class="ml-6 px-6 py-2 rounded-3xl bg-indigo-200">ファイル選択</label>
          <p id="displayImageName" class="mt-3">ファイルが選択されていません</p>
          <input onchange="displayImageName()" type="file" name="image" id="image" accept="image/jpeg, image/png" class="hidden">
        </div>
        <div class="block">
          <label class="text-gray-700" for="score">優先度,評価</label>
          <select name="score" class="
                    block
                    w-full
                    mt-1
                    rounded-md
                    border-gray-300
                    shadow-sm
                    focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                  ">
            <option value="1" <?php if ($element['score'] == 1) {
                                echo "selected";
                              }  ?>>1</option>
            <option value="2" <?php if ($element['score'] == 2) {
                                echo "selected";
                              } ?>>2</option>
            <option value="3" <?php if ($element['score'] == 3) {
                                echo "selected";
                              } ?>>3</option>
            <option value="4" <?php if ($element['score'] == 4) {
                                echo "selected";
                              } ?>>4</option>
            <option value="5" <?php if ($element['score'] == 5) {
                                echo "selected";
                              } ?>>5</option>
          </select>
        </div>
        <div class="block">
          <label class="text-gray-700" for="mediums">サービス</label>
          <select name="mediums" class="
                    block
                    w-full
                    mt-1
                    rounded-md
                    border-gray-300
                    shadow-sm
                    focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                  ">
            <option value="kindle" <?php if ($element['mediums'] == "kindle") {
                                      echo "selected";
                                    }  ?>>kindle</option>
            <option value="kobo" <?php if ($element['mediums'] == "kobo") {
                                    echo "selected";
                                  } ?>>kobo</option>
            <option value="paper-books" <?php if ($element['mediums'] == "paper-books") {
                                          echo "selected";
                                        } ?>>paper books</option>
          </select>
        </div>
        <div class="flex justify-between">
          <label class="text-gray-700" name="status">状況</label>
          <div class="basis-[80%] sm:basis-2/3 grid grid-cols-3">
            <div>
              <input type="radio" name="status" value="未読" <?php echo ($element['status'] === '未読') ? 'checked' : ''; ?>>
              <label for="unread">未読</label>
            </div>
            <div>
              <input type="radio" name="status" value="読了" class="ml-4" <?php echo ($element['status'] === '読了') ? 'checked' : ''; ?>>
              <label for="done">読了</label>
            </div>
            <div>
              <input type="radio" name="status" value="欲しい" class="ml-4" <?php echo ($element['status'] === '欲しい') ? 'checked' : ''; ?>>
              <label for="want">欲しい</label>
            </div>
          </div>
        </div>
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <input type="hidden" name="old_image_URL" value="<?php echo $element['image_url'] ?>">
        <input type="hidden" name="old_image_key" value="<?php echo $element['image_key']; ?>">
        <button type="submit" name="<?php echo $btn_name ?>" class="px-6 py-2 rounded-3xl bg-indigo-200">登録</button>
      </div>
    </form>
  </div>
</body>
<script src="./main.js"></script>

</html>