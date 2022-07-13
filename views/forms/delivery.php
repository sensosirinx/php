<div class="container-form">
    <h3><?=$title?></h3>
    <form id="form" action="/delivery_fast" method="get" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="source_kladr" class="form-label">Откуда:</label>
            <select class="selectpicker" data-live-search="true" name="source_kladr" title="Город отправки" required>
                <?php foreach ($cities as $city):?>
                <option data-tokens="<?=$city?>" value="<?=$city?>"><?=$city?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="mb-3">
            <label for="target_kladr" class="form-label">Куда:</label>
            <select class="selectpicker" data-live-search="true" name="target_kladr" title="Город назначения" required>
                <?php foreach ($cities as $city):?>
                    <option data-tokens="<?=$city?>" value="<?=$city?>"><?=$city?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="mb-3">
            <label for="target_kladr" class="form-label">Вес:</label>
            <select class="selectpicker" aria-label="Вес" name="weight" required>
                <option value="0.5" selected>До 0.5 кг</option>
                <option value="2">до 2 кг</option>
                <option value="5">до 5 кг</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Тип доставки:</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="delivery_type" id="delivery_type1" value="1" checked>
                <label class="form-check-label" for="delivery_type1">
                    Быстрая доставка
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="delivery_type" id="delivery_type2" value="2">
                <label class="form-check-label" for="delivery_type2">
                    Медленная доставка
                </label>
            </div>
        </div>
        <div class="mb-3">
            <label for="target_kladr" class="form-label">Служба доставки:</label>
            <select class="selectpicker" name="delivery_service" aria-label="Служба доставки" required>
                <option value="sdek" selected>СДЭК</option>
                <option value="pek">ПЭК</option>
                <option value="rupost">Почта России</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Рассчитать</button>
    </form>
</div>
