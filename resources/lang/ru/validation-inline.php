<?php

/*
|--------------------------------------------------------------------------
| Validation Language Lines
|--------------------------------------------------------------------------
|
| The following language lines contain the default error messages used by
| the validator class. Some of these rules have multiple versions such
| as the size rules. Feel free to tweak each of these messages here.
|
*/

return [
    'accepted'             => 'Должно быть принято.',
    'active_url'           => 'Недействительный URL.',
    'after'                => 'Дата должна быть больше :date.',
    'after_or_equal'       => 'Дата должна быть больше или равняться :date.',
    'alpha'                => 'Здесь могут быть только буквы.',
    'alpha_dash'           => 'Здесь могут быть только буквы, цифры, дефис и нижнее подчеркивание.',
    'alpha_num'            => 'Здесь могут быть только буквы и цифры.',
    'array'                => 'Здесь должен быть массив.',
    'attached'             => 'Уже прикреплено.',
    'before'               => 'Дата здесь должна быть раньше :date.',
    'before_or_equal'      => 'Дата здесь должна быть раньше или равняться :date.',
    'between'              => [
        'array'   => 'Количество элементов должно быть между :min и :max.',
        'file'    => 'Размер файла должен быть между :min и :max Килобайт(а).',
        'numeric' => 'Значение должно быть между :min и :max.',
        'string'  => 'Количество символов должно быть между :min и :max.',
    ],
    'boolean'              => 'Поле должно иметь значение логического типа.',
    'confirmed'            => 'Не совпадает с подтверждением.',
    'date'                 => 'Не является датой.',
    'date_equals'          => 'Дата должна быть равной :date.',
    'date_format'          => 'Не соответствует формату :format.',
    'different'            => 'Значение должно отличаться от :other',
    'digits'               => 'Длина должна быть :digits.',
    'digits_between'       => 'Длина должна быть между :min и :max.',
    'dimensions'           => 'Изображение имеет недопустимые размеры.',
    'distinct'             => 'Поле содержит повторяющееся значение.',
    'email'                => 'Электронный адрес должен быть действительным.',
    'ends_with'            => 'Должно заканчиваться одним из следующих значений: :values',
    'exists'               => 'Выбранное значение некорректно.',
    'file'                 => 'Содержимое должно быть файлом.',
    'filled'               => 'Обязательно для заполнения.',
    'gt'                   => [
        'array'   => 'Количество элементов должно быть больше :value.',
        'file'    => 'Размер файла должен быть больше :value Килобайт(а).',
        'numeric' => 'Значение должно быть больше :value.',
        'string'  => 'Количество символов должно быть больше :value.',
    ],
    'gte'                  => [
        'array'   => 'Количество элементов должно быть :value или больше.',
        'file'    => 'Размер файла должен быть :value Килобайт(а) или больше.',
        'numeric' => 'Значение должно быть :value или больше.',
        'string'  => 'Количество символов должно быть :value или больше.',
    ],
    'image'                => 'Здесь должно быть изображение.',
    'in'                   => 'Выбранное значение ошибочно.',
    'in_array'             => 'Значение не существует в :other.',
    'integer'              => 'Должно быть целое число.',
    'ip'                   => 'Должен быть действительный IP-адрес.',
    'ipv4'                 => 'Должен быть действительный IPv4-адрес.',
    'ipv6'                 => 'Должен быть действительный IPv6-адрес.',
    'json'                 => 'Должно быть JSON строкой.',
    'lt'                   => [
        'array'   => 'Количество элементов должно быть меньше :value.',
        'file'    => 'Размер файла должен быть меньше :value Килобайт(а).',
        'numeric' => 'Значение должно быть меньше :value.',
        'string'  => 'Количество символов должно быть меньше :value.',
    ],
    'lte'                  => [
        'array'   => 'Количество элементов должно быть :value или меньше.',
        'file'    => 'Размер файла должен быть :value Килобайт(а) или меньше.',
        'numeric' => 'Значение должно быть :value или меньше.',
        'string'  => 'Количество символов должно быть :value или меньше.',
    ],
    'max'                  => [
        'array'   => 'Количество элементов не может превышать :max.',
        'file'    => 'Размер файла не может быть больше :max Килобайт(а).',
        'numeric' => 'Значение не может быть больше :max.',
        'string'  => 'Количество символов не может превышать :max.',
    ],
    'mimes'                => 'Должен быть файл одного из следующих типов: :values.',
    'mimetypes'            => 'Должен быть файл одного из следующих типов: :values.',
    'min'                  => [
        'array'   => 'Количество элементов должно быть не меньше :min.',
        'file'    => 'Размер файла должен быть не меньше :min Килобайт(а).',
        'numeric' => 'Значение должно быть не меньше :min.',
        'string'  => 'Количество символов должно быть не меньше :min.',
    ],
    'multiple_of'          => 'Значение должно быть кратным :value',
    'not_in'               => 'Выбранное значение ошибочно.',
    'not_regex'            => 'Выбранный формат ошибочный.',
    'numeric'              => 'Здесь должно быть число.',
    'password'             => 'Неверный пароль.',
    'present'              => 'Значение должно быть.',
    'prohibited'           => 'Данное значение запрещено.',
    'prohibited_if'        => 'Значение запрещено, когда :other равно :value.',
    'prohibited_unless'    => 'Значение запрещено, если :other не входит в :values.',
    'regex'                => 'Ошибочный формат.',
    'relatable'            => 'Объект не может быть связан с этим ресурсом.',
    'required'             => 'Обязательно для заполнения.',
    'required_if'          => 'Обязательно для заполнения, когда :other равно :value.',
    'required_unless'      => 'Обязательно для заполнения, когда :other не равно :values.',
    'required_with'        => 'Обязательно для заполнения, когда :values указано.',
    'required_with_all'    => 'Обязательно для заполнения, когда :values указано.',
    'required_without'     => 'Обязательно для заполнения, когда :values не указано.',
    'required_without_all' => 'Обязательно для заполнения, когда ни одно из :values не указано.',
    'same'                 => 'Значение должно совпадать с :other.',
    'size'                 => [
        'array'   => 'Количество элементов должно быть равным :size.',
        'file'    => 'Размер файла должен быть равен :size Килобайт(а).',
        'numeric' => 'Значение должно быть равным :size.',
        'string'  => 'Количество символов должно быть равным :size.',
    ],
    'starts_with'          => 'Значение должно начинаться из одного из следующих значений: :values',
    'string'               => 'Здесь должна быть строка.',
    'timezone'             => 'Должен быть действительный часовой пояс.',
    'unique'               => 'Такое значение уже существует.',
    'uploaded'             => 'Загрузка не удалась.',
    'url'                  => 'Ошибочный формат URL.',
    'uuid'                 => 'Должен быть корректный UUID.',
    'custom'               => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],
    'attributes'           => [],
];
