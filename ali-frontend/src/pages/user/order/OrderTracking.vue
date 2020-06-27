<template>
  <div class="vx-row">
    <div class="vx-col w-full md:w-4/5 lg:w-3/4 mt-12 md:mt-0 mr-auto ml-auto">
      <div class="order-tracking">
        <vx-card>
          <ul class="process-bar">
            <li class="completed">
              <span>Đang xử lý</span>
            </li>
            <li class="completed">
              <span>Thanh toán đơn hàng</span>
            </li>
            <li class="completed">
              <span>Đóng gói - Sẵn sàng giao hàng</span>
            </li>
            <li class="active-progress">
              <span>Đang vận chuyển</span>
            </li>
            <li class="last">
              <span class="success">Giao hàng thành công</span>
            </li>
          </ul>
        </vx-card>
      </div>
      <div class="status-update mt-8">
        <vx-card title="Activity Timeline">
          <ul class="activity-timeline">
            <li>
              <div class="timeline-icon bg-primary">
                <feather-icon icon="PlusIcon" svgClasses="text-white stroke-current w-5 h-5"></feather-icon>
              </div>
              <div class="timeline-info">
                <p class="font-semibold">Task Added</p>
                <span class="activity-desc">Bonbon macaroon jelly beans gummi bears jelly lollipop apple</span>
              </div>
              <small class="text-grey activity-e-time">25 days ago</small>
            </li>
            <li>
              <div class="timeline-icon bg-warning">
                <feather-icon icon="AlertCircleIcon" svgClasses="text-white stroke-current w-5 h-5"></feather-icon>
              </div>
              <div class="timeline-info">
                <p class="font-semibold">Task Updated</p>
                <span class="activity-desc">Cupcake gummi bears soufflé caramels candy</span>
              </div>
              <small class="text-grey activity-e-time">15 days ago</small>
            </li>
            <li>
              <div class="timeline-icon bg-success">
                <feather-icon icon="CheckIcon" svgClasses="text-white stroke-current w-5 h-5"></feather-icon>
              </div>
              <div class="timeline-info">
                <p class="font-semibold">Task Completed</p>
                <span class="activity-desc">Candy ice cream cake. Halvah gummi bears</span>
              </div>
              <small class="text-grey activity-e-time">20 mins ago</small>
            </li>
          </ul>
        </vx-card>
      </div>
    </div>
  </div>
</template>
<style lang="scss">
  @import "../../../styles/order.scss";
</style>
